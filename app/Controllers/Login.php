<?php

namespace App\Controllers;


use App\Models\UsersModel;
use CodeIgniter\HTTP\RedirectResponse;
use Libraries\SonicMailer;
use PHPMailer\PHPMailer\Exception;


class Login extends BaseController
{
    protected $UsersModel;

    public function __construct()
    {
        parent::__construct();
        $this->UsersModel = new UsersModel();
    }

    public function index()
    {

        if ($this->session->has('logged_in')) {
            return redirect()->to('/home');
        } else {
            if ($this->request->getHeaderLine('Referer') != null) {
                //$this->session->set('redirectTo', $this->request->getHeaderLine('Referer'));
            }
            return view('login/index');
        }
    }


    public function verify(): RedirectResponse
    {
        if ($this->request->getMethod(true) == 'POST') {
            $data = $this->request->getPost();
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            $user = $this->UsersModel->loginInfo($username);
            if ($user && $this->UsersModel->verifyPassword($password, $user['password'])) {

                $sessionData = $this->sessionData($user);
                $this->session->set('loggedIn', $sessionData);
                if ($sessionData['roleId'] == 3) {
                    return redirect()->to(route_to('marketing-dashboard'));
                } else {
                    return redirect()->to(route_to('dashboard'));
                }
            } else {
                $this->session->setFlashdata('postData', [
                    'status' => 'error',
                    'message' => 'Invalid username or password'
                ]);
                return redirect()->to('/login');
            }
        } else {
            return redirect()->to('/');
        }
    }

    private function sessionData($user)
    {
        $sessionData = [
            'userId' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'username' => $user['username'],
            'roleId' => $user['role_id'],
            'role' => $user['role_name'],
        ];


        return $sessionData;
    }


    public function verificationProcess()
    {
        if ($this->session->has("userData")) {

            $userData = $this->session->get('userData');
            if (($userData['authType'] === "2fa" || $userData['authType'] == "both") && !$this->session->has("2faVerified")) {
                $model = new LoginHistoryModel();
                $history = $model->where([
                    'userId' => $userData['id'],
                    'uaHash' => md5($_SERVER['HTTP_USER_AGENT'])
                ])->findAll();

                if (count($history) === 0 || empty($_COOKIE['verify-auth'])) {
                    return redirect()->to('auth/authentication');
                }
            }
            if (empty($userData['passwordUpdated'])) {
                $userData['passwordUpdated'] = date('Y-m-d', strtotime('-35 days'));
            }
            if ($userData['authType'] != "2fa") {
                $lastPasswordUpdate = date('Y-m-d', strtotime($userData['passwordUpdated']));
                $diff = date_diff(date_create(date('Y-m-d', strtotime($lastPasswordUpdate))), date_create(date("Y-m-d", strtotime("now"))));
                if ($diff->d >= 30 || $diff->m >= 1) {
                    return redirect('auth/change-password');
                }
            }
            $this->session->remove("userData");
            $this->session->remove("2faVerified");
            $sessionData = $this->sessionData($userData);
            $this->session->set('loggedIn', $sessionData);
        }
        if ($this->session->get("redirectTo")) {
            //            $referer = $this->session->get("redirectTo");
//            $this->session->remove("redirectTo");
//            return redirect()->to($referer);
        }
        return redirect()->to('/');
    }

    public function passwordChange()
    {
        if ($this->session->has("userData")) {
            $data = [
                "message" => '',
                "status" => '',
                'title' => "Password changed"
            ];
            if ($this->session->has("error")) {
                $data['message'] = $this->session->get("error");
            }
            if ($this->session->has("success")) {
                $data['message'] = $this->session->get("success");
                $data['status'] = "successful";
            }
            return view('auth/view_force_password', $data);
        }
        return redirect()->to('/');

    }

    public function authEmail()
    {

        if ($this->session->has('userData')) {
            $data = [
                'message' => 'Email sent successfully',
                'error' => false
            ];
            $resendEmail = true;
            if ($this->session->has('2fa')) {
                $authData = $this->session->get('2fa');
                if (strtotime('+5 minutes', $authData['time']) > strtotime('now')) {
                    $resendEmail = false;
                    $data['error'] = true;
                    $data['message'] = "Email already sent. Please wait for 5 minutes for new confirmation code.";
                }
            }
            if ($this->session->has("2faVerify")) {
                $fSession = $this->session->get("2faVerify");
                if ($fSession == "invalidcode") {
                    $data['error'] = true;
                    $data['message'] = "Invalid confirmation code.";
                } elseif ($fSession == "codeExpired") {
                    $resendEmail = true;
                    $data['error'] = true;
                    $data['message'] = "Your confirmation code is expired. New code sent to your email address";
                }

            }

            if ($resendEmail || true) {
                $data['emailSend'] = $this->send2faEmail();
                if (!$data['emailSend']) {
                    $data['error'] = true;
                    $data['message'] = "Failed to send email.";
                }
            }
            return view('auth/view_twofa_email', $data);
        }
        $this->session->setFlashdata('postData', [
            'status' => 'error',
            'message' => 'Failed to authenticate! Try again'
        ]);
        return redirect()->to('/');

    }

    private function send2faEmail(): bool
    {
        if ($this->session->has("userData")) {
            $userData = $this->session->get("userData");

            $mailer = new SonicMailer();
            try {
                $mailer->mail->addAddress($userData['email']);
            } catch (Exception $e) {
                return false;
            }
            $mailer->mail->Subject = 'MCP Insight Account Verification';
            $request = service('request');
            $data = [
                'code' => $this->generateRandomString(),
                'time' => strtotime('now'),
                'email' => $userData['email'],
                'ip' => $request->getIPAddress()
            ];
            try {
                $message = view('auth/email_template', $data);
                $mailer->mail->Body = $message;
                $mailer->mail->AltBody = 'No need to Reply';
                $mailer->mail->send();
                $this->session->set('2fa', $data);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    function generateRandomString($length = 6): string
    {
        return "123456";
        $characters = 'm1c23012345d6d789rabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function emailVerification(): RedirectResponse
    {
        if ($this->session->has('2fa')) {
            $authData = $this->session->get('2fa');
            $userData = $this->session->get('userData');
            $data = $this->request->getPost();
            if (!empty($data['twofa']) && strtotime('+5 minutes', $authData['time']) < strtotime('now')) {
                $this->session->setFlashdata('2faVerify', 'codeExpired');
                return redirect()->back();
            }

            if ($data['twofa'] === $authData['code']) {
                $this->session->remove('2fa');
                $this->session->set('2faVerified', "true");


                $model = new LoginHistoryModel();
                $model->save([
                    'userId' => $userData['id'],
                    'uaHash' => md5($_SERVER['HTTP_USER_AGENT']),
                    'ip' => $this->request->getIPAddress(),
                    'userAgent' => $_SERVER['HTTP_USER_AGENT']
                ]);

                setcookie('verify-auth', 1, time() + (86400 * 30), "/");
                return redirect()->to('verification-process');

            }
            $this->session->setFlashdata('2faVerify', 'invalidcode');

            return redirect()->back();
        }
        return redirect()->to('/');


    }

    public function updatePassword(): RedirectResponse
    {
        if ($this->session->has("userData")) {

            $inputs = $this->request->getPost();
            $userData = $this->session->get('userData');

            if (empty($inputs['inputPasswordOld']) || empty($inputs['inputPasswordNew']) || empty($inputs['inputPasswordNewVerify'])) {
                $this->session->setFlashdata("error", "Please enter valid password");
                return redirect()->back();
            } else if ($inputs['inputPasswordNew'] != $inputs['inputPasswordNewVerify']) {
                $this->session->setFlashdata("error", "Passwords do not match");
                return redirect()->back();
            } else {
                try {
                    $this->UsersModel->update($userData['id'], [
                        'password' => $this->UsersModel->encryptPassword($inputs['inputPasswordNew']),
                        'passwordUpdated' => strtotime('now')
                    ]);
                    $this->session->setFlashdata("success", "Password updated successfully");

                } catch (Exception $e) {
                    $this->session->setFlashdata("error", "Password you entered is incorrect");
                }
                return redirect()->back();

            }

        }

        return redirect()->to('/');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->route('login');
    }
}
