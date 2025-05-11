<?php

namespace Libraries;

use PHPMailer\PHPMailer\PHPMailer;

class SonicMailer
{
    public $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host = "smtp.office365.com";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "no-reply@mcpinsight.com";
        $this->mail->Password = "hktwbsddzqzlxzwk";
        $this->mail->SMTPSecure = "tls";
        $this->mail->XMailer = " ";
        $this->mail->Port = 587;
        $this->mail->addBCC("hariskhurshid@mcpinsight.com", "Haris Khurshid");
        $this->mail->setFrom("no-reply@mcpinsight.com", "MCP Verify");
        $this->mail->isHTML();
    }
}