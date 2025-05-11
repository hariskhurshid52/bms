<?php

namespace App\Libraries;


use App\Models\AlertCycleModel;
use App\Models\AlertTemplatesModel;
use App\Models\AssignedNotificationModel;
use App\Models\AssignedTemplateModel;
use App\Models\EmailServiceModel;
use App\Models\NotificationModel;
use App\Models\ShortCodesModel;
use App\Models\UsersModel;
use CodeIgniter\CLI\CLI;
use DateTime;

class EmailProcess
{
    /**
     * @throws \Exception
     */

    public function NewOrderCreationNotification($shortCodeId)
    {
        $this->newOrderEmailNotification($shortCodeId);
        $this->newOrderAlertNotification($shortCodeId);
    }
    private function newOrderEmailNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[ProcessOrderCreationNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'new_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[ProcessOrderCreationNotification] [$shortCodeId] Email Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "new_order"', 'left')
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
            $partnerEmails = [];
            foreach ($partners as $partner) {
                if (!isset($partnerEmails[$partner['userId']])) {
                    $partnerEmails[$partner['userId']] = [
                        'name' => $partner['name'],
                        'primaryEmail' => $partner['primaryEmail'],
                        'alternativeEmail' => []
                    ];
                }

                if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                    $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                }

            }
            foreach ($partnerEmails as $emails) {
                if (count($emails['alternativeEmail']) === 0) {
                    $emailAlert['to'][] = [
                        'name' => $emails['name'],
                        'email' => $emails['primaryEmail']
                    ];

                } else {
                    foreach ($emails['alternativeEmail'] as $email) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $email
                        ];
                    }
                }
            }

        }

        $model = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $model->save($emailAlert);
        if ($saved) {
            return true;
        } else {
            return false;
        }
    }

    private function newOrderAlertNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[newOrderAlertNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'new_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[newOrderAlertNotification] [$shortCodeId] Email Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];

            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }



    public function inProcessOrderCreationNotification($shortCodeIds)
    {
        $this->inProcessEmailNotification($shortCodeIds);
        $this->inProcessAlertNotification($shortCodeIds);
    }
    private function inProcessEmailNotification($shortCodeIds)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCodes = $mdShortCodeOrder->whereIn('shortcodes.id', $shortCodeIds)
            ->join('countrycsps', 'shortcodes.countryCspId = countrycsps.id', 'left')
            ->join('csps', 'countrycsps.cspId = csps.id', 'left')
            ->join('countryservices', 'shortcodes.masterService = countryservices.id', 'left')
            ->join('services', 'countryservices.serviceId = services.id', 'left')
            ->join('servicetypes', 'shortcodes.serviceType = servicetypes.id', 'left')
            ->join('servicenetopactions', 'shortcodes.netopAction = servicenetopactions.id', 'left')
            ->join('shortcodeorders', 'shortcodes.id = shortcodeorders.shortCodeId', 'left')
            ->join('mediaTypes', 'shortcodes.mediaTypeId = mediaTypes.id', 'left')
            ->join('serviceinitiations', 'shortcodes.promotionType = serviceinitiations.id', 'left')
            ->join('orderstatus', 'shortcodeorders.orderStatusId = orderstatus.id', 'left')
            ->join('countryaggregators', 'shortcodes.countryAggregatorId = countryaggregators.id', 'left')
            ->join('aggregators', 'countryaggregators.aggregatorId = aggregators.id', 'left')
            ->join('bindnamemappings', 'shortCodes.bindName = bindnamemappings.id', 'left')
            ->select('shortcodes.shortcode as shortCode, 
                 shortcodes.id as shortCodeId,
                 shortcodes.serviceName,
                 csps.name as merchantName,
                 aggregators.name as partnerName,
                 mediaTypes.type as mediaTypeName,
                 bindnamemappings.name as bindName,
                 servicetypes.name as serviceTypeName,
                 servicenetopactions.name as netopActionName,
                 operatorId,
                 countryAggregatorId
                 ')
            ->findAll();
        if (count($shortCodes) == 0) {
            log_message('error', "[inProcessEmailNotification] [$shortCodeIds] Short Code not found");
            return false;
        }

        $operatorId = $shortCodes[0]['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'process_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[ProcessOrderCreationNotification] [$shortCodeIds] Email Template not found");
            return false;
        }

        $templateId = $template['templateId'];

        $partnerShortCodes = [];
        foreach ($shortCodes as $shortCode) {
            if (!isset($partnerShortCodes[$shortCode['countryAggregatorId']])) {
                $partnerShortCodes[$shortCode['countryAggregatorId']] = [
                    'name' => $shortCode['partnerName'],
                    'shortCodes' => []
                ];
            }
            $partnerShortCodes[$shortCode['countryAggregatorId']]['shortCodes'][] = $shortCode;
        }

        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUsers = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }

        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }
        if (count($emailAlert['to']) > 0) {

            $html = view('email-templates/table-short-code-list', [
                'partnerShortCodes' => $partnerShortCodes
            ]);
            $emailAlert['message'] = str_replace('[TABLE]', $html, $emailAlert['message']);
        }




        $mdEmailService = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $mdEmailService->save($emailAlert);
        if (!$saved) {
            log_message("error", "[inProcessEmailNotification] : Failed to send email for operators");
        }


        if ($template['partners'] !== "none") {
            foreach ($partnerShortCodes as $partnerId => $pShortCodes) {
                $emailAlert = [
                    'subject' => $template['subject'],
                    'message' => $template['html'],
                    'to' => [],
                    'cc' => [],
                ];

                $partners = $mdUsers
                    ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "process_order"', 'left')
                    ->where(['operatorId' => $operatorId, 'roleId' => 3]);
                if ($template['partners'] == "relative") {
                    $users = $partners->where(['partnerId' => $partnerId]);
                }
                $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
                $partnerEmails = [];
                foreach ($partners as $partner) {
                    if (!isset($partnerEmails[$partner['userId']])) {
                        $partnerEmails[$partner['userId']] = [
                            'name' => $partner['name'],
                            'primaryEmail' => $partner['primaryEmail'],
                            'alternativeEmail' => []
                        ];
                    }

                    if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                        $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                    }

                }
                foreach ($partnerEmails as $emails) {
                    if (count($emails['alternativeEmail']) === 0) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $emails['primaryEmail']
                        ];

                    } else {
                        foreach ($emails['alternativeEmail'] as $email) {
                            $emailAlert['to'][] = [
                                'name' => $emails['name'],
                                'email' => $email
                            ];
                        }
                    }
                }
                $html = view('email-templates/table-short-code-list', [
                    'partnerShortCodes' => [
                        [
                            'name' => $pShortCodes['name'],
                            'shortCodes' => $pShortCodes['shortCodes']
                        ]
                    ]
                ]);
                $emailAlert['message'] = str_replace('[TABLE]', $html, $emailAlert['message']);
                $emailAlert['to'] = json_encode($emailAlert['to']);
                $emailAlert['cc'] = json_encode($emailAlert['cc']);
                $saved = $mdEmailService->save($emailAlert);
                if (!$saved) {
                    log_message("error", "[inProcessEmailNotification] : Failed to send email for operators");
                }
            }


        }


        return true;

    }
    private function inProcessAlertNotification($shortCodeIds)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCodes = $mdShortCodeOrder->whereIn('id', $shortCodeIds)->findAll();
        if (count($shortCodes) == 0) {
            log_message('error', "[inProcessAlertNotification] [$shortCodeIds] Short Code not found");
            return false;
        }
        $operatorId = $shortCodes[0]['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'process_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[inProcessAlertNotification]  Notification Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partnerIds = array_unique(array_column($shortCodes, 'countryAggregatorId'));

                $partners = $partners->whereIn("partnerId", $partnerIds);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];
            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }



    public function liveOrderCreationNotification($shortCodeIds)
    {
        $this->liveEmailNotification($shortCodeIds);
        $this->liveAlertNotification($shortCodeIds);
    }
    private function liveEmailNotification($shortCodeIds)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCodes = $mdShortCodeOrder->whereIn('shortcodes.id', $shortCodeIds)
            ->join('countrycsps', 'shortcodes.countryCspId = countrycsps.id', 'left')
            ->join('csps', 'countrycsps.cspId = csps.id', 'left')
            ->join('countryservices', 'shortcodes.masterService = countryservices.id', 'left')
            ->join('services', 'countryservices.serviceId = services.id', 'left')
            ->join('servicetypes', 'shortcodes.serviceType = servicetypes.id', 'left')
            ->join('servicenetopactions', 'shortcodes.netopAction = servicenetopactions.id', 'left')
            ->join('shortcodeorders', 'shortcodes.id = shortcodeorders.shortCodeId', 'left')
            ->join('mediaTypes', 'shortcodes.mediaTypeId = mediaTypes.id', 'left')
            ->join('serviceinitiations', 'shortcodes.promotionType = serviceinitiations.id', 'left')
            ->join('orderstatus', 'shortcodeorders.orderStatusId = orderstatus.id', 'left')
            ->join('countryaggregators', 'shortcodes.countryAggregatorId = countryaggregators.id', 'left')
            ->join('aggregators', 'countryaggregators.aggregatorId = aggregators.id', 'left')
            ->join('bindnamemappings', 'shortCodes.bindName = bindnamemappings.id', 'left')
            ->select('shortcodes.shortcode as shortCode, 
                 shortcodes.id as shortCodeId,
                 shortcodes.serviceName,
                 csps.name as merchantName,
                 aggregators.name as partnerName,
                 mediaTypes.type as mediaTypeName,
                 bindnamemappings.name as bindName,
                 servicetypes.name as serviceTypeName,
                 servicenetopactions.name as netopActionName,
                 operatorId,
                 countryAggregatorId
                 ')
            ->findAll();
        if (count($shortCodes) == 0) {
            log_message('error', "[inProcessEmailNotification] [$shortCodeIds] Short Code not found");
            return false;
        }

        $operatorId = $shortCodes[0]['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'live_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[ProcessOrderCreationNotification] [$shortCodeIds] Email Template not found");
            return false;
        }

        $templateId = $template['templateId'];

        $partnerShortCodes = [];
        foreach ($shortCodes as $shortCode) {
            if (!isset($partnerShortCodes[$shortCode['countryAggregatorId']])) {
                $partnerShortCodes[$shortCode['countryAggregatorId']] = [
                    'name' => $shortCode['partnerName'],
                    'shortCodes' => []
                ];
            }
            $partnerShortCodes[$shortCode['countryAggregatorId']]['shortCodes'][] = $shortCode;
        }

        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUsers = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }

        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }
        if (count($emailAlert['to']) > 0) {

            $html = view('email-templates/table-short-code-list', [
                'partnerShortCodes' => $partnerShortCodes
            ]);
            $emailAlert['message'] = str_replace('[TABLE]', $html, $emailAlert['message']);
        }




        $mdEmailService = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $mdEmailService->save($emailAlert);
        if (!$saved) {
            log_message("error", "[inProcessEmailNotification] : Failed to send email for operators");
        }


        if ($template['partners'] !== "none") {
            foreach ($partnerShortCodes as $partnerId => $pShortCodes) {
                $emailAlert = [
                    'subject' => $template['subject'],
                    'message' => $template['html'],
                    'to' => [],
                    'cc' => [],
                ];

                $partners = $mdUsers
                    ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "live_order"', 'left')
                    ->where(['operatorId' => $operatorId, 'roleId' => 3]);
                if ($template['partners'] == "relative") {
                    $users = $partners->where(['partnerId' => $partnerId]);
                }
                $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
                $partnerEmails = [];
                foreach ($partners as $partner) {
                    if (!isset($partnerEmails[$partner['userId']])) {
                        $partnerEmails[$partner['userId']] = [
                            'name' => $partner['name'],
                            'primaryEmail' => $partner['primaryEmail'],
                            'alternativeEmail' => []
                        ];
                    }

                    if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                        $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                    }

                }
                foreach ($partnerEmails as $emails) {
                    if (count($emails['alternativeEmail']) === 0) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $emails['primaryEmail']
                        ];

                    } else {
                        foreach ($emails['alternativeEmail'] as $email) {
                            $emailAlert['to'][] = [
                                'name' => $emails['name'],
                                'email' => $email
                            ];
                        }
                    }
                }
                $html = view('email-templates/table-short-code-list', [
                    'partnerShortCodes' => [
                        [
                            'name' => $pShortCodes['name'],
                            'shortCodes' => $pShortCodes['shortCodes']
                        ]
                    ]
                ]);
                $emailAlert['message'] = str_replace('[TABLE]', $html, $emailAlert['message']);
                $emailAlert['to'] = json_encode($emailAlert['to']);
                $emailAlert['cc'] = json_encode($emailAlert['cc']);
                $saved = $mdEmailService->save($emailAlert);
                if (!$saved) {
                    log_message("error", "[inProcessEmailNotification] : Failed to send email for operators");
                }
            }


        }


        return true;

    }
    private function liveAlertNotification($shortCodeIds)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCodes = $mdShortCodeOrder->whereIn('id', $shortCodeIds)->findAll();
        if (count($shortCodes) == 0) {
            log_message('error', "[inProcessAlertNotification] [$shortCodeIds] Short Code not found");
            return false;
        }
        $operatorId = $shortCodes[0]['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'live_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[inProcessAlertNotification]  Notification Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partnerIds = array_unique(array_column($shortCodes, 'countryAggregatorId'));

                $partners = $partners->whereIn("partnerId", $partnerIds);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];
            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }


    
    public function processCancelOrderNotification($shortCodeId)
    {
        $this->canceOrderEmailNotification($shortCodeId);
        $this->cancelOrderAlertNotification($shortCodeId);
    }
    private function canceOrderEmailNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[canceOrderEmailNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'cancel_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[canceOrderEmailNotification] [$shortCodeId] Email Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "cancel_order"', 'left')
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
            $partnerEmails = [];
            foreach ($partners as $partner) {
                if (!isset($partnerEmails[$partner['userId']])) {
                    $partnerEmails[$partner['userId']] = [
                        'name' => $partner['name'],
                        'primaryEmail' => $partner['primaryEmail'],
                        'alternativeEmail' => []
                    ];
                }

                if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                    $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                }

            }
            foreach ($partnerEmails as $emails) {
                if (count($emails['alternativeEmail']) === 0) {
                    $emailAlert['to'][] = [
                        'name' => $emails['name'],
                        'email' => $emails['primaryEmail']
                    ];

                } else {
                    foreach ($emails['alternativeEmail'] as $email) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $email
                        ];
                    }
                }
            }

        }

        $model = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $model->save($emailAlert);
        if ($saved) {
            return true;
        } else {
            return false;
        }
    }

    private function cancelOrderAlertNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[cancelOrderAlertNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'cancel_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[cancelOrderAlertNotification] [$shortCodeId] Alert Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];

            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }
    

    
    public function processCancelReservationNotification($shortCodeId)
    {
        $this->canceReservationEmailNotification($shortCodeId);
        $this->cancelReservationAlertNotification($shortCodeId);
    }
    private function canceReservationEmailNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[canceReservationEmailNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'cancel_reservation', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[canceReservationEmailNotification] [$shortCodeId] Email Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "cancel_reservation"', 'left')
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
            $partnerEmails = [];
            foreach ($partners as $partner) {
                if (!isset($partnerEmails[$partner['userId']])) {
                    $partnerEmails[$partner['userId']] = [
                        'name' => $partner['name'],
                        'primaryEmail' => $partner['primaryEmail'],
                        'alternativeEmail' => []
                    ];
                }

                if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                    $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                }

            }
            foreach ($partnerEmails as $emails) {
                if (count($emails['alternativeEmail']) === 0) {
                    $emailAlert['to'][] = [
                        'name' => $emails['name'],
                        'email' => $emails['primaryEmail']
                    ];

                } else {
                    foreach ($emails['alternativeEmail'] as $email) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $email
                        ];
                    }
                }
            }

        }

        $model = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $model->save($emailAlert);
        if ($saved) {
            return true;
        } else {
            return false;
        }
    }

    private function cancelReservationAlertNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[cancelReservationAlertNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'cancel_reservation', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[cancelReservationAlertNotification] [$shortCodeId] Alert Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];

            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }

    
    public function processMigrationOrderNotification($shortCodeId)
    {
        $this->migrationEmailNotification($shortCodeId);
        $this->migrationAlertNotification($shortCodeId);
    }
    private function migrationEmailNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[migrationEmailNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'migration_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[migrationEmailNotification] [$shortCodeId] Email Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "migration_order"', 'left')
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
            $partnerEmails = [];
            foreach ($partners as $partner) {
                if (!isset($partnerEmails[$partner['userId']])) {
                    $partnerEmails[$partner['userId']] = [
                        'name' => $partner['name'],
                        'primaryEmail' => $partner['primaryEmail'],
                        'alternativeEmail' => []
                    ];
                }

                if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                    $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                }

            }
            foreach ($partnerEmails as $emails) {
                if (count($emails['alternativeEmail']) === 0) {
                    $emailAlert['to'][] = [
                        'name' => $emails['name'],
                        'email' => $emails['primaryEmail']
                    ];

                } else {
                    foreach ($emails['alternativeEmail'] as $email) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $email
                        ];
                    }
                }
            }

        }

        $model = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $model->save($emailAlert);
        if ($saved) {
            return true;
        } else {
            return false;
        }
    }

    private function migrationAlertNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[cancelOrderAlertNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'migration_order', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[cancelOrderAlertNotification] [$shortCodeId] Alert Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];

            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }


    
    public function processCancelMigrationOrderNotification($shortCodeId)
    {
        $this->cancelMigrationEmailNotification($shortCodeId);
        $this->cancelMigrationAlertNotification($shortCodeId);
    }
    private function cancelMigrationEmailNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[cancelMigrationEmailNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'cancel_migraiton', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[cancelMigrationEmailNotification] [$shortCodeId] Email Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "cancel_migraiton"', 'left')
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
            $partnerEmails = [];
            foreach ($partners as $partner) {
                if (!isset($partnerEmails[$partner['userId']])) {
                    $partnerEmails[$partner['userId']] = [
                        'name' => $partner['name'],
                        'primaryEmail' => $partner['primaryEmail'],
                        'alternativeEmail' => []
                    ];
                }

                if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                    $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                }

            }
            foreach ($partnerEmails as $emails) {
                if (count($emails['alternativeEmail']) === 0) {
                    $emailAlert['to'][] = [
                        'name' => $emails['name'],
                        'email' => $emails['primaryEmail']
                    ];

                } else {
                    foreach ($emails['alternativeEmail'] as $email) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $email
                        ];
                    }
                }
            }

        }

        $model = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $model->save($emailAlert);
        if ($saved) {
            return true;
        } else {
            return false;
        }
    }

    private function cancelMigrationAlertNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[cancelMigrationAlertNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'cancel_migraiton', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[cancelMigrationAlertNotification] [$shortCodeId] Alert Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];

            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }


    
    public function processApproveMigrationOrderNotification($shortCodeId)
    {
        $this->approveMigrationEmailNotification($shortCodeId);
        $this->approveMigrationAlertNotification($shortCodeId);
    }
    private function approveMigrationEmailNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[approveMigrationEmailNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'email', 'keyAction' => 'approve_migraiton', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[approveMigrationEmailNotification] [$shortCodeId] Email Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $emailAlert = [
            'subject' => $template['subject'],
            'message' => $template['html'],
            'to' => [],
            'cc' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('name,email')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $emailAlert['to'][] = [
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])->select('name,email')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $emailAlert['to'][] = [
                        'name' => $user['name'],
                        'email' => $user['email']
                    ];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "approve_migraiton"', 'left')
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
            $partnerEmails = [];
            foreach ($partners as $partner) {
                if (!isset($partnerEmails[$partner['userId']])) {
                    $partnerEmails[$partner['userId']] = [
                        'name' => $partner['name'],
                        'primaryEmail' => $partner['primaryEmail'],
                        'alternativeEmail' => []
                    ];
                }

                if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                    $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                }

            }
            foreach ($partnerEmails as $emails) {
                if (count($emails['alternativeEmail']) === 0) {
                    $emailAlert['to'][] = [
                        'name' => $emails['name'],
                        'email' => $emails['primaryEmail']
                    ];

                } else {
                    foreach ($emails['alternativeEmail'] as $email) {
                        $emailAlert['to'][] = [
                            'name' => $emails['name'],
                            'email' => $email
                        ];
                    }
                }
            }

        }

        $model = new EmailServiceModel();
        $emailAlert['to'] = json_encode($emailAlert['to']);
        $emailAlert['cc'] = json_encode($emailAlert['cc']);
        $saved = $model->save($emailAlert);
        if ($saved) {
            return true;
        } else {
            return false;
        }
    }

    private function approveMigrationAlertNotification($shortCodeId)
    {
        $mdShortCodeOrder = new ShortCodesModel();
        $shortCode = $mdShortCodeOrder->where('id', $shortCodeId)->first();
        if (empty($shortCode)) {
            log_message('error', "[approveMigrationAlertNotification] [$shortCodeId] Short Code not found");
            return false;
        }
        $operatorId = $shortCode['operatorId'];
        $alertTemplatesModel = new AlertTemplatesModel();
        $template = $alertTemplatesModel->where(['type' => 'notification', 'keyAction' => 'approve_migraiton', 'operatorId' => $operatorId])
            ->select('name,subject,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->first();

        if (empty($template)) {
            log_message('error', "[approveMigrationAlertNotification] [$shortCodeId] Alert Template not found");
            return false;
        }
        $templateId = $template['templateId'];
        $alertConfig = [
            'title' => $template['subject'],
            'message' => $template['html'],
            'userIds' => [],
        ];

        $model = new AssignedTemplateModel();
        $mdUser = new UsersModel();
        $assignedUsers = $model
            ->select('users.id as userId')
            ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
            ->where(['templateId' => $templateId, 'users.operatorId' => $operatorId])
            ->findAll();
        if (count($assignedUsers) > 0) {

            foreach ($assignedUsers as $user) {
                $alertConfig['userIds'][] = $user['userId'];
            }
        }
        $mdUsers = new UsersModel();
        if (!empty($template['notifyOperator']) && $template['notifyOperator'] == 'yes') {
            $users = $mdUsers->where(['operatorId' => $shortCode['operatorId'], 'roleId' => 2])
                ->select('id as userId')->findAll();
            if (count($users) > 0) {
                foreach ($users as $user) {
                    $alertConfig['userIds'][] = $user['userId'];
                }
            }
        }

        if ($template['partners'] !== "none") {
            $partners = $mdUser
                ->where(['operatorId' => $operatorId, 'roleId' => 3]);
            if ($template['partners'] == "relative") {
                $partners = $partners->where(['partnerId' => $shortCode['countryAggregatorId']]);
            }
            $partners = $partners->select('users.id as userId')->findAll();
            foreach ($partners as $partner) {
                $alertConfig['userIds'][] = $partner['userId'];

            }

        }
        $notif = new NotificationModel();
        $saved = $notif->save([
            'title' => $alertConfig['title'],
            'message' => $alertConfig['message'],
        ]);
        if ($saved) {
            $notificaiotnId = $notif->getInsertID();
            $model = new AssignedNotificationModel();
            $insData = [];
            foreach ($alertConfig['userIds'] as $userId) {
                $insData[] = [
                    'notificationId' => $notificaiotnId,
                    'userId' => $userId
                ];
            }
            return $model->insertBatch($insData);
        }
        return false;
    }

    public function processSubmissionCycleUpdateNotifications($alertData): bool
    {

        $operatorId = session()->get('loggedIn')['operatorId'];
        $model = new AlertTemplatesModel();
        if ($alertData['notifyPartner']['email'] === "yes") {

            $template = $model->where(['type' => 'email', 'operatorId' => $operatorId, 'keyAction' => 'submission_cycle_update'])->first();
            if (empty($template)) {
                log_message("error", "Email Template for $operatorId not found");
                return false;
            }
            $emailConfig = [
                'to' => [],
                'html' => !empty($alertData['emailTemplate']) ? $alertData['emailTemplate'] : $template['html']
            ];


            $templateId = $template['id'];
            $mdUsers = new UsersModel();
            $mdAssignedTemplate = new AssignedTemplateModel();
            $assignedTemplateUsers = $mdAssignedTemplate->where('templateId', $templateId)->select('id,roleId')->findAll();

            if (!empty($assignedTemplateUsers)) {
                $roleIds = array_column($assignedTemplateUsers, 'roleId');

                $userList = $mdUsers->whereIn('roleId', $roleIds)->where('operatorId', $operatorId)->select('name,email')->findAll();

                if (!empty($userList)) {
                    foreach ($userList as $user) {
                        $emailConfig['to'][] = [
                            'name' => $user['name'],
                            'email' => $user['email']
                        ];
                    }
                }
            }

            if ($template['notifyOperator'] == "yes") {
                $operatorUsers = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])->select('name,email')->findAll();
                ;
                if (!empty($operatorUsers)) {
                    foreach ($operatorUsers as $user) {
                        $emailConfig['to'][] = [
                            'name' => $user['name'],
                            'email' => $user['email']
                        ];
                    }
                }
            }
            if ($alertData['notifyPartner']['email'] === "yes") {
                $changeType = $alertData['submissionChange'] ? 'submission_cycle_update' : 'delivery_cycle_update';
                $partners = $mdUsers
                    ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "submission_cycle_update"', 'left')
                    ->where(['operatorId' => $operatorId, 'roleId' => 3])
                    ->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
                $partnerEmails = [];
                foreach ($partners as $partner) {
                    if (!isset($partnerEmails[$partner['userId']])) {
                        $partnerEmails[$partner['userId']] = [
                            'name' => $partner['name'],
                            'primaryEmail' => $partner['primaryEmail'],
                            'alternativeEmail' => []
                        ];
                    }

                    if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                        $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                    }

                }

                foreach ($partnerEmails as $emails) {
                    if (count($emails['alternativeEmail']) === 0) {
                        $emailConfig['to'][] = [
                            'name' => $emails['name'],
                            'email' => $emails['primaryEmail']
                        ];
                    } else {
                        foreach ($emails['alternativeEmail'] as $email) {
                            $emailConfig['to'][] = [
                                'name' => $emails['name'],
                                'email' => $email
                            ];
                        }
                    }
                }
            }
            if (count($emailConfig['to']) == 0) {
                log_message("error", "No email addresses found for Operator $operatorId");
                return false;
            }
            $emailService = new EmailServiceModel();
            $saved = $emailService->save([
                'to' => json_encode($emailConfig['to']),
                'subject' => $template['subject'],
                'message' => $emailConfig['html'],
                'time' => $template['time']
            ]);

        }
        if ($alertData['notifyPartner']['notification'] === "yes") {
            $template = $model->where(['type' => 'notification', 'operatorId' => $operatorId, 'keyAction' => 'submission_cycle_update'])->first();
            if (empty($template)) {
                log_message("error", "Alert Template for $operatorId not found");
                return false;
            }
            $alertConfig = [
                'users' => [],
                'content' => !empty($alertData['notificationTemplate']) ? $alertData['notificationTemplate'] : $template['html']
            ];
            $templateId = $template['id'];
            $mdUsers = new UsersModel();
            $mdAssignedTemplate = new AssignedTemplateModel();
            $assignedTemplateUsers = $mdAssignedTemplate->where('templateId', $templateId)->select('id,roleId')->findAll();

            if (!empty($assignedTemplateUsers)) {
                $roleIds = array_column($assignedTemplateUsers, 'roleId');

                $userList = $mdUsers->whereIn('roleId', $roleIds)->where('operatorId', $operatorId)->select('id')->findAll();

                if (!empty($userList)) {
                    $userIds = array_column($userList, 'id');
                    $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                }
            }
            if ($template['notifyOperator'] == "yes") {
                $operatorUsers = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])->select('id')->findAll();
                ;
                if (!empty($operatorUsers)) {
                    $userIds = array_column($operatorUsers, 'id');
                    $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                }
            }

            if ($alertData['notifyPartner']['notification'] === "yes") {
                $partners = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 3])->select('id')->findAll();

                if (!empty($partners)) {
                    $userIds = array_column($partners, 'id');
                    $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                }

            }
            if (count($alertConfig['users']) == 0) {
                log_message("error", "No users found");
                return false;
            }

            $notif = new NotificationModel();
            $saved = $notif->save([
                'title' => $template['subject'],
                'message' => $alertConfig['content'],
            ]);
            if ($saved) {
                $model = new AssignedNotificationModel();
                $insData = [];
                foreach ($alertConfig['users'] as $userId) {
                    $insData[] = [
                        'notificationId' => $notif->getInsertID(),
                        'userId' => $userId
                    ];
                }
                return $model->insertBatch($insData);

            }


        }

        return true;
    }
    public function processDeliveryCycleUpdateNotifications($alertData): bool
    {

        $operatorId = session()->get('loggedIn')['operatorId'];
        $model = new AlertTemplatesModel();
        if ($alertData['notifyPartner']['email'] === "yes") {

            $template = $model->where(['type' => 'email', 'operatorId' => $operatorId, 'keyAction' => 'delivery_cycle_update'])->first();
            if (empty($template)) {
                log_message("error", "Email Template for $operatorId not found");
                return false;
            }
            $emailConfig = [
                'to' => [],
                'html' => !empty($alertData['emailTemplate']) ? $alertData['emailTemplate'] : $template['html']
            ];


            $templateId = $template['id'];
            $mdUsers = new UsersModel();
            $mdAssignedTemplate = new AssignedTemplateModel();
            $assignedTemplateUsers = $mdAssignedTemplate->where('templateId', $templateId)->select('id,roleId')->findAll();

            if (!empty($assignedTemplateUsers)) {
                $roleIds = array_column($assignedTemplateUsers, 'roleId');

                $userList = $mdUsers->whereIn('roleId', $roleIds)->where('operatorId', $operatorId)->select('name,email')->findAll();

                if (!empty($userList)) {
                    foreach ($userList as $user) {
                        $emailConfig['to'][] = [
                            'name' => $user['name'],
                            'email' => $user['email']
                        ];
                    }
                }
            }

            if ($template['notifyOperator'] == "yes") {
                $operatorUsers = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])->select('name,email')->findAll();
                ;
                if (!empty($operatorUsers)) {
                    foreach ($operatorUsers as $user) {
                        $emailConfig['to'][] = [
                            'name' => $user['name'],
                            'email' => $user['email']
                        ];
                    }
                }
            }
            if ($alertData['notifyPartner']['email'] === "yes") {
                $changeType = $alertData['submissionChange'] ? 'submission_cycle_update' : 'delivery_cycle_update';
                $partners = $mdUsers
                    ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "delivery_cycle_update"', 'left')
                    ->where(['operatorId' => $operatorId, 'roleId' => 3])
                    ->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
                $partnerEmails = [];
                foreach ($partners as $partner) {
                    if (!isset($partnerEmails[$partner['userId']])) {
                        $partnerEmails[$partner['userId']] = [
                            'name' => $partner['name'],
                            'primaryEmail' => $partner['primaryEmail'],
                            'alternativeEmail' => []
                        ];
                    }

                    if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                        $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                    }

                }

                foreach ($partnerEmails as $emails) {
                    if (count($emails['alternativeEmail']) === 0) {
                        $emailConfig['to'][] = [
                            'name' => $emails['name'],
                            'email' => $emails['primaryEmail']
                        ];
                    } else {
                        foreach ($emails['alternativeEmail'] as $email) {
                            $emailConfig['to'][] = [
                                'name' => $emails['name'],
                                'email' => $email
                            ];
                        }
                    }
                }
            }
            if (count($emailConfig['to']) == 0) {
                log_message("error", "No email addresses found for Operator $operatorId");
                return false;
            }
            $emailService = new EmailServiceModel();
            $saved = $emailService->save([
                'to' => json_encode($emailConfig['to']),
                'subject' => $template['subject'],
                'message' => $emailConfig['html'],
                'time' => $template['time']
            ]);

        }
        if ($alertData['notifyPartner']['notification'] === "yes") {
            $template = $model->where(['type' => 'notification', 'operatorId' => $operatorId, 'keyAction' => 'delivery_cycle_update'])->first();
            if (empty($template)) {
                log_message("error", "Alert Template for $operatorId not found");
                return false;
            }
            $alertConfig = [
                'users' => [],
                'content' => !empty($alertData['notificationTemplate']) ? $alertData['notificationTemplate'] : $template['html']
            ];
            $templateId = $template['id'];
            $mdUsers = new UsersModel();
            $mdAssignedTemplate = new AssignedTemplateModel();
            $assignedTemplateUsers = $mdAssignedTemplate->where('templateId', $templateId)->select('id,roleId')->findAll();

            if (!empty($assignedTemplateUsers)) {
                $roleIds = array_column($assignedTemplateUsers, 'roleId');

                $userList = $mdUsers->whereIn('roleId', $roleIds)->where('operatorId', $operatorId)->select('id')->findAll();

                if (!empty($userList)) {
                    $userIds = array_column($userList, 'id');
                    $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                }
            }
            if ($template['notifyOperator'] == "yes") {
                $operatorUsers = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 2])->select('id')->findAll();
                ;
                if (!empty($operatorUsers)) {
                    $userIds = array_column($operatorUsers, 'id');
                    $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                }
            }

            if ($alertData['notifyPartner']['notification'] === "yes") {
                $partners = $mdUsers->where(['operatorId' => $operatorId, 'roleId' => 3])->select('id')->findAll();

                if (!empty($partners)) {
                    $userIds = array_column($partners, 'id');
                    $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                }

            }
            if (count($alertConfig['users']) == 0) {
                log_message("error", "No users found");
                return false;
            }

            $notif = new NotificationModel();
            $saved = $notif->save([
                'title' => $template['subject'],
                'message' => $alertConfig['content'],
            ]);
            if ($saved) {
                $model = new AssignedNotificationModel();
                $insData = [];
                foreach ($alertConfig['users'] as $userId) {
                    $insData[] = [
                        'notificationId' => $notif->getInsertID(),
                        'userId' => $userId
                    ];
                }
                return $model->insertBatch($insData);

            }


        }

        return true;
    }








    public function ScheduledSubmissionDateEmailReminder(): void
    {
        CLI::write("Running ScheduledSubmissionDateReminder", 'green');

        $currentDate = date('Y-m-d');
        $cyclesModel = new AlertCycleModel();
        $cycles = $cyclesModel
            ->select('OP.operatorName, alertCycles.operatorId, alertCycles.submissionDate,alertCycles.id as cycleId')
            ->join('operators as OP', 'OP.id = alertCycles.operatorId', 'left')
            ->where(['alertCycles.submissionReminder' => 'new', 'alertCycles.submissionDate >=' => $currentDate])
            ->orderBy('alertCycles.submissionDate', 'ASC')
            ->findAll();

        $operatorClosestCycles = [];
        foreach ($cycles as $cycle) {
            if (!isset($operatorClosestCycles[$cycle['operatorId']])) {
                $operatorClosestCycles[$cycle['operatorId']] = $cycle;
            } else {
                $currentClosest = $operatorClosestCycles[$cycle['operatorId']];
                if (strtotime($cycle['submissionDate']) < strtotime($currentClosest['submissionDate'])) {
                    $operatorClosestCycles[$cycle['operatorId']] = $cycle;
                }
            }
        }


        $model = new AlertTemplatesModel();
        $templates = $model->where(['type' => 'email', 'keyAction' => 'submission_date_reminder'])
            ->select('name,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->findAll();
        $operatorTemplates = [];
        foreach ($templates as $template) {
            $operatorTemplates[$template['operatorId']] = $template;
        }

        foreach ($operatorClosestCycles as $operatorId => $cycle) {
            CLI::write("\n \n ******* Operator: {$cycle['operatorName']} - Cycle: {$cycle['cycleId']} - Submission Date: {$cycle['submissionDate']} ********* \n \n ", "purple");

            if (isset($operatorTemplates[$operatorId])) {
                $operatorTemplate = $operatorTemplates[$operatorId];
                $submissionDate = $cycle['submissionDate'];
                $frequency = $operatorTemplate['frequency'];


                $currentDateObj = new DateTime($currentDate);
                $submissionDateObj = new DateTime($submissionDate);
                $interval = $currentDateObj->diff($submissionDateObj);
                $daysDiff = $interval->days;

                if ($daysDiff === $frequency) {
                    if (date('H:i:s') != $operatorTemplate['time']) {
                        CLI::write("Time is not {$operatorTemplate['time']}", "yellow");
                        continue;
                    }
                    $emailAlert = [
                        'subject' => $operatorTemplate['name'],
                        'message' => $operatorTemplate['html'],
                        'to' => [],
                        'cc' => [],
                    ];
                    $model = new AssignedTemplateModel();
                    $mdUser = new UsersModel();
                    $assignedUsers = $model
                        ->select('name,email')
                        ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
                        ->where(['templateId' => $operatorTemplate['templateId'], 'users.operatorId' => $operatorId])
                        ->findAll();
                    if (count($assignedUsers) > 0) {

                        foreach ($assignedUsers as $assignedUser) {
                            CLI::write("{$assignedUser['name']} - {$assignedUser['email']}", "green");
                            $emailAlert['to'][] = [
                                'name' => $assignedUser['name'],
                                'email' => $assignedUser['email']
                            ];
                        }
                    }
                    if ($operatorTemplate['notifyOperator'] == "yes") {
                        $operatorManagers = $mdUser
                            ->select('name,email')
                            ->where(['operatorId' => $operatorId, 'roleId' => 2])
                            ->findAll();
                        if (count($operatorManagers) > 0) {
                            foreach ($operatorManagers as $operatorManager) {
                                CLI::write("{$operatorManager['name']} - {$operatorManager['email']}", "green");
                                $emailAlert['to'][] = [
                                    'name' => $operatorManager['name'],
                                    'email' => $operatorManager['email']
                                ];
                            }
                        }
                    }
                    if ($operatorTemplate['partners'] != "none") {
                        $partners = $mdUser
                            ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "scheduled_date"', 'left')
                            ->where(['operatorId' => $operatorId, 'roleId' => 3])
                            ->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
                        $partnerEmails = [];
                        foreach ($partners as $partner) {
                            if (!isset($partnerEmails[$partner['userId']])) {
                                $partnerEmails[$partner['userId']] = [
                                    'name' => $partner['name'],
                                    'primaryEmail' => $partner['primaryEmail'],
                                    'alternativeEmail' => []
                                ];
                            }

                            if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                                $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                            }

                        }

                        foreach ($partnerEmails as $emails) {
                            if (count($emails['alternativeEmail']) === 0) {
                                $emailAlert['to'][] = [
                                    'name' => $emails['name'],
                                    'email' => $emails['primaryEmail']
                                ];
                                CLI::write("{$emails['name']} - {$emails['primaryEmail']}", "green");
                            } else {
                                foreach ($emails['alternativeEmail'] as $email) {
                                    $emailAlert['to'][] = [
                                        'name' => $emails['name'],
                                        'email' => $email
                                    ];
                                    CLI::write("{$emails['name']} - {$email}", "green");

                                }
                            }
                        }

                    }

                    $update = $cyclesModel->update($cycle['cycleId'], ['submissionReminder' => 'scheduled', 'submissionReminderScheduledAt' => date('Y-m-d H:i:s')]);

                    if ($update) {
                        $model = new EmailServiceModel();
                        $emailAlert['to'] = json_encode($emailAlert['to']);
                        $emailAlert['cc'] = json_encode($emailAlert['cc']);
                        $saved = $model->save($emailAlert);
                        if ($saved) {
                            CLI::write("Email Alert Scheduled", "green");
                        } else {
                            $update = $cyclesModel->update($cycle['cycleId'], ['submissionReminder' => 'new']);
                            CLI::write($model->errors(), "red");
                            CLI::write("Email Alert Not Scheduled", "red");
                        }


                    } else {
                        CLI::write($cyclesModel->errors(), "red");
                        CLI::write("Email Alert Not Scheduled", "red");
                    }
                } else {
                    CLI::write("Difference between current date {$currentDate} and submission date {$submissionDate} is $daysDiff days", "yellow");
                }


            } else {
                CLI::write("For {$cycle['operatorName']} Alerts template not found", "red");
            }
        }
    }
    public function ScheduledDeliveryDateEmailReminder(): void
    {
        CLI::write("Running ScheduledDeliveryDateEmailReminder", 'green');

        $currentDate = date('Y-m-d');
        $cyclesModel = new AlertCycleModel();
        $cycles = $cyclesModel
            ->select('OP.operatorName, alertCycles.operatorId, alertCycles.deliveryDate,alertCycles.id as cycleId')
            ->join('operators as OP', 'OP.id = alertCycles.operatorId', 'left')
            ->where(['alertCycles.submissionReminder' => 'new', 'alertCycles.deliveryDate >=' => $currentDate])
            ->orderBy('alertCycles.deliveryDate', 'ASC')
            ->findAll();

        $operatorClosestCycles = [];
        foreach ($cycles as $cycle) {
            if (!isset($operatorClosestCycles[$cycle['operatorId']])) {
                $operatorClosestCycles[$cycle['operatorId']] = $cycle;
            } else {
                $currentClosest = $operatorClosestCycles[$cycle['operatorId']];
                if (strtotime($cycle['deliveryDate']) < strtotime($currentClosest['deliveryDate'])) {
                    $operatorClosestCycles[$cycle['operatorId']] = $cycle;
                }
            }
        }


        $model = new AlertTemplatesModel();
        $templates = $model->where(['type' => 'email', 'keyAction' => 'delivery_date_reminder'])
            ->select('name,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->findAll();
        $operatorTemplates = [];
        foreach ($templates as $template) {
            $operatorTemplates[$template['operatorId']] = $template;
        }

        foreach ($operatorClosestCycles as $operatorId => $cycle) {
            CLI::write("\n \n ******* Operator: {$cycle['operatorName']} - Cycle: {$cycle['cycleId']} - Delivery Date: {$cycle['deliveryDate']} ********* \n \n ", "purple");

            if (isset($operatorTemplates[$operatorId])) {
                $operatorTemplate = $operatorTemplates[$operatorId];
                $deliveryDate = $cycle['deliveryDate'];
                $frequency = $operatorTemplate['frequency'];


                $currentDateObj = new DateTime($currentDate);
                $submissionDateObj = new DateTime($deliveryDate);
                $interval = $currentDateObj->diff($submissionDateObj);
                $daysDiff = $interval->days;

                if ($daysDiff === $frequency) {
                    if (date('H:i:s') != $operatorTemplate['time']) {
                        CLI::write("Time is not {$operatorTemplate['time']}", "yellow");
                        continue;
                    }
                    $emailAlert = [
                        'subject' => $operatorTemplate['name'],
                        'message' => $operatorTemplate['html'],
                        'to' => [],
                        'cc' => [],
                    ];
                    $model = new AssignedTemplateModel();
                    $assignedUsers = $model
                        ->select('name,email')
                        ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
                        ->where(['templateId' => $operatorTemplate['templateId'], 'users.operatorId' => $operatorId])
                        ->findAll();
                    if (count($assignedUsers) > 0) {

                        foreach ($assignedUsers as $assignedUser) {
                            CLI::write("{$assignedUser['name']} - {$assignedUser['email']}", "green");
                            $emailAlert['to'][] = [
                                'name' => $assignedUser['name'],
                                'email' => $assignedUser['email']
                            ];
                        }
                    }
                    if ($operatorTemplate['notifyOperator'] == "yes") {
                        $user = new UsersModel();
                        $operatorManagers = $user
                            ->select('name,email')
                            ->where(['operatorId' => $operatorId, 'roleId' => 2])
                            ->findAll();
                        if (count($operatorManagers) > 0) {
                            foreach ($operatorManagers as $operatorManager) {
                                CLI::write("{$operatorManager['name']} - {$operatorManager['email']}", "green");
                                $emailAlert['to'][] = [
                                    'name' => $operatorManager['name'],
                                    'email' => $operatorManager['email']
                                ];
                            }
                        }
                    }
                    if ($operatorTemplate['partners'] != "none") {
                        $user = new UsersModel();
                        $partners = $user
                            ->join('notificationEmailConfig as emailConfig', 'users.id = emailConfig.userID AND emailConfig.alertType = "delivery_date"', 'left')
                            ->where(['operatorId' => $operatorId, 'roleId' => 3])
                            ->select('users.id as userId,users.name,users.email as primaryEmail,emailConfig.email as alternativeEmail')->findAll();
                        $partnerEmails = [];
                        foreach ($partners as $partner) {
                            if (!isset($partnerEmails[$partner['userId']])) {
                                $partnerEmails[$partner['userId']] = [
                                    'name' => $partner['name'],
                                    'primaryEmail' => $partner['primaryEmail'],
                                    'alternativeEmail' => []
                                ];
                            }

                            if (!in_array($partner['alternativeEmail'], $partnerEmails[$partner['userId']]['alternativeEmail']) && !empty($partner['alternativeEmail'])) {
                                $partnerEmails[$partner['userId']]['alternativeEmail'][] = $partner['alternativeEmail'];
                            }

                        }

                        foreach ($partnerEmails as $emails) {
                            if (count($emails['alternativeEmail']) === 0) {
                                $emailAlert['to'][] = [
                                    'name' => $emails['name'],
                                    'email' => $emails['primaryEmail']
                                ];
                                CLI::write("{$emails['name']} - {$emails['primaryEmail']}", "green");
                            } else {
                                foreach ($emails['alternativeEmail'] as $email) {
                                    $emailAlert['to'][] = [
                                        'name' => $emails['name'],
                                        'email' => $email
                                    ];
                                    CLI::write("{$emails['name']} - {$email}", "green");

                                }
                            }
                        }


                    }
                    $update = $cyclesModel->update($cycle['cycleId'], ['deliveryReminder' => 'scheduled', 'deliveryReminderScheduledAt' => date('Y-m-d H:i:s')]);

                    if ($update) {
                        $model = new EmailServiceModel();
                        $emailAlert['to'] = json_encode($emailAlert['to']);
                        $emailAlert['cc'] = json_encode($emailAlert['cc']);
                        $saved = $model->save($emailAlert);
                        if ($saved) {
                            CLI::write("Email Alert Scheduled", "green");
                        } else {
                            $update = $cyclesModel->update($cycle['cycleId'], ['deliveryReminder' => 'new']);
                            CLI::write($model->errors(), "red");
                            CLI::write("Email Alert Not Scheduled", "red");
                        }


                    } else {
                        CLI::write($cyclesModel->errors(), "red");
                        CLI::write("Email Alert Not Scheduled", "red");
                    }
                } else {
                    CLI::write("Difference between current date {$currentDate} and delivery date {$deliveryDate} is $daysDiff days", "yellow");
                }


            } else {
                CLI::write("Operator: {$cycle['operatorName']} Alerts template not found", "red");
            }
        }
    }

    public function ScheduledSubmissionNotificationReminder()
    {
        CLI::write("ScheduledSubmissionNotificationReminder");
        $currentDate = date('Y-m-d');
        $cyclesModel = new AlertCycleModel();
        $cycles = $cyclesModel
            ->select('OP.operatorName, alertCycles.operatorId, alertCycles.submissionDate,alertCycles.id as cycleId')
            ->join('operators as OP', 'OP.id = alertCycles.operatorId', 'left')
            ->where(['alertCycles.submissionNotificationReminder' => 'new', 'alertCycles.submissionDate >=' => $currentDate])
            ->orderBy('alertCycles.submissionDate', 'ASC')
            ->findAll();

        $operatorClosestCycles = [];
        foreach ($cycles as $cycle) {
            if (!isset($operatorClosestCycles[$cycle['operatorId']])) {
                $operatorClosestCycles[$cycle['operatorId']] = $cycle;
            } else {
                $currentClosest = $operatorClosestCycles[$cycle['operatorId']];
                if (strtotime($cycle['submissionDate']) < strtotime($currentClosest['submissionDate'])) {
                    $operatorClosestCycles[$cycle['operatorId']] = $cycle;
                }
            }
        }


        $model = new AlertTemplatesModel();
        $templates = $model->where(['type' => 'notification', 'keyAction' => 'submission_date_reminder'])
            ->select('name,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->findAll();
        $operatorTemplates = [];
        foreach ($templates as $template) {
            $operatorTemplates[$template['operatorId']] = $template;
        }

        foreach ($operatorClosestCycles as $operatorId => $cycle) {
            CLI::write("\n \n ******* Operator: {$cycle['operatorName']} - Cycle: {$cycle['cycleId']} - Submission Date: {$cycle['submissionDate']} ********* \n \n ", "purple");

            if (isset($operatorTemplates[$operatorId])) {
                $operatorTemplate = $operatorTemplates[$operatorId];
                $submissionDate = $cycle['submissionDate'];
                $frequency = $operatorTemplate['frequency'];


                $currentDateObj = new DateTime($currentDate);
                $submissionDateObj = new DateTime($submissionDate);
                $interval = $currentDateObj->diff($submissionDateObj);
                $daysDiff = $interval->days;

                if ($daysDiff === $frequency || true) {
                    if (date('H:i:s') != $operatorTemplate['time'] && false) {
                        CLI::write("Time is not {$operatorTemplate['time']}", "yellow");
                        continue;
                    }
                    $alertConfig = [
                        'title' => $operatorTemplate['name'],
                        'content' => $operatorTemplate['html'],
                        'users' => [],
                    ];
                    $model = new AssignedTemplateModel();
                    $mdUser = new UsersModel();
                    $assignedUsers = $model
                        ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
                        ->where(['templateId' => $operatorTemplate['templateId'], 'users.operatorId' => $operatorId])->select('users.id')
                        ->findAll();
                    if (count($assignedUsers) > 0) {
                        $userIds = array_column($assignedUsers, 'id');
                        $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                    }
                    if ($operatorTemplate['notifyOperator'] == "yes") {
                        $operatorManagers = $mdUser
                            ->where(['operatorId' => $operatorId, 'roleId' => 2])->select('id')
                            ->findAll();
                        if (count($operatorManagers) > 0) {
                            $userIds = array_column($operatorManagers, 'id');
                            $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                        }
                    }
                    if ($operatorTemplate['partners'] != "none") {
                        $partners = $mdUser
                            ->where(['operatorId' => $operatorId, 'roleId' => 3])
                            ->select('id')->findAll();

                        if (count($partners) > 0) {
                            $userIds = array_column($partners, 'id');
                            $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                        }
                    }

                    if (count($alertConfig['users']) > 0) {
                        $notif = new NotificationModel();
                        $saved = $notif->save([
                            'title' => '',
                            'message' => $alertConfig['content'],
                        ]);
                        if ($saved) {
                            $model = new AssignedNotificationModel();
                            $insData = [];
                            foreach ($alertConfig['users'] as $userId) {
                                $insData[] = [
                                    'notificationId' => $notif->getInsertID(),
                                    'userId' => $userId
                                ];
                            }
                            CLI::write("Notification for submission date reminder saved", "green");

                            $cyclesModel->update($cycle['cycleId'], ['submissionNotificationReminder' => 'scheduled', 'sNRScheduledAt' => date('Y-m-d H:i:s')]);
                            return $model->insertBatch($insData);

                        }
                    }

                } else {
                    CLI::write("Difference between current date {$currentDate} and submission date {$submissionDate} is $daysDiff days", "yellow");
                }


            } else {
                CLI::write("For {$cycle['operatorName']} Alerts template not found", "red");
            }
        }
    }

    public function ScheduledDeliveryNotificationReminder()
    {
        CLI::write("ScheduledDeliveryNotificationReminder");
        $currentDate = date('Y-m-d');
        $cyclesModel = new AlertCycleModel();
        $cycles = $cyclesModel
            ->select('OP.operatorName, alertCycles.operatorId, alertCycles.deliveryDate,alertCycles.id as cycleId')
            ->join('operators as OP', 'OP.id = alertCycles.operatorId', 'left')
            ->where(['alertCycles.deliveryNotificationReminder' => 'new', 'alertCycles.submissionDate >=' => $currentDate])
            ->orderBy('alertCycles.submissionDate', 'ASC')
            ->findAll();

        $operatorClosestCycles = [];
        foreach ($cycles as $cycle) {
            if (!isset($operatorClosestCycles[$cycle['operatorId']])) {
                $operatorClosestCycles[$cycle['operatorId']] = $cycle;
            } else {
                $currentClosest = $operatorClosestCycles[$cycle['operatorId']];
                if (strtotime($cycle['deliveryDate']) < strtotime($currentClosest['deliveryDate'])) {
                    $operatorClosestCycles[$cycle['operatorId']] = $cycle;
                }
            }
        }


        $model = new AlertTemplatesModel();
        $templates = $model->where(['type' => 'notification', 'keyAction' => 'delivery_date_reminder'])
            ->select('name,html,partners,frequency,notifyOperator,operatorId,time,id as templateId')
            ->findAll();
        $operatorTemplates = [];
        foreach ($templates as $template) {
            $operatorTemplates[$template['operatorId']] = $template;
        }

        foreach ($operatorClosestCycles as $operatorId => $cycle) {
            CLI::write("\n \n ******* Operator: {$cycle['operatorName']} - Cycle: {$cycle['cycleId']} - Delivery Date: {$cycle['deliveryDate']} ********* \n \n ", "purple");

            if (isset($operatorTemplates[$operatorId])) {
                $operatorTemplate = $operatorTemplates[$operatorId];
                $deliveryDate = $cycle['deliveryDate'];
                $frequency = $operatorTemplate['frequency'];


                $currentDateObj = new DateTime($currentDate);
                $deliveryDateDateObj = new DateTime($deliveryDate);
                $interval = $currentDateObj->diff($deliveryDateDateObj);
                $daysDiff = $interval->days;

                if ($daysDiff === $frequency || true) {
                    if (date('H:i:s') != $operatorTemplate['time'] && false) {
                        CLI::write("Time is not {$operatorTemplate['time']}", "yellow");
                        continue;
                    }
                    $alertConfig = [
                        'title' => $operatorTemplate['name'],
                        'content' => $operatorTemplate['html'],
                        'users' => [],
                    ];
                    $model = new AssignedTemplateModel();
                    $mdUser = new UsersModel();
                    $assignedUsers = $model
                        ->join('users', 'assignedTemplates.roleId = users.roleId', 'right')
                        ->where(['templateId' => $operatorTemplate['templateId'], 'users.operatorId' => $operatorId])->select('users.id')
                        ->findAll();
                    if (count($assignedUsers) > 0) {
                        $userIds = array_column($assignedUsers, 'id');
                        $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                    }
                    if ($operatorTemplate['notifyOperator'] == "yes") {
                        $operatorManagers = $mdUser
                            ->where(['operatorId' => $operatorId, 'roleId' => 2])->select('id')
                            ->findAll();
                        if (count($operatorManagers) > 0) {
                            $userIds = array_column($operatorManagers, 'id');
                            $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                        }
                    }
                    if ($operatorTemplate['partners'] != "none") {
                        $partners = $mdUser
                            ->where(['operatorId' => $operatorId, 'roleId' => 3])
                            ->select('id')->findAll();

                        if (count($partners) > 0) {
                            $userIds = array_column($partners, 'id');
                            $alertConfig['users'] = array_merge($alertConfig['users'], $userIds);
                        }
                    }

                    if (count($alertConfig['users']) > 0) {
                        $notif = new NotificationModel();
                        $saved = $notif->save([
                            'title' => '',
                            'message' => $alertConfig['content'],
                        ]);
                        if ($saved) {
                            $model = new AssignedNotificationModel();
                            $insData = [];
                            foreach ($alertConfig['users'] as $userId) {
                                $insData[] = [
                                    'notificationId' => $notif->getInsertID(),
                                    'userId' => $userId
                                ];
                            }
                            CLI::write("Notification for delivery date reminder saved", "green");

                            $cyclesModel->update($cycle['cycleId'], ['deliveryNotificationReminder' => 'scheduled', 'dNRScheduledAt' => date('Y-m-d H:i:s')]);
                            return $model->insertBatch($insData);

                        }
                    }

                } else {
                    CLI::write("Difference between current date {$currentDate} and submission date {$deliveryDate} is $daysDiff days", "yellow");
                }


            } else {
                CLI::write("For {$cycle['operatorName']} Alerts template not found", "red");
            }
        }
    }



}