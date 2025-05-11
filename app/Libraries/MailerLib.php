<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;

class MailerLib
{
    public $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $email = 'no-reply@mcpinsight.com';
        $pass = 'hktwbsddzqzlxzwk';
        $sender = 'MCP Insight';
        $smtp = "smtp.office365.com";
        //Server settings
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = $smtp;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $email;
        $this->mail->Password = $pass;
        $this->mail->SMTPSecure = 'TLS';
        $this->mail->Port = 587;
        //Recipients
        $this->mail->addReplyTo($email, $sender);
        $this->mail->addReplyTo($email, $sender);

        $this->mail->addBCC('hariskhurshid@mcpinsight.com', 'Muhammad Haris Khurshid');
        $this->mail->isHTML(true);
    }
}