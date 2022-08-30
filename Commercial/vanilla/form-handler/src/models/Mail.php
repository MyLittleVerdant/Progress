<?php

namespace FormHandler\models;

use FormHandler\helpers\Logging;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer;
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Host = 'smtp.beget.com';
        $this->mail->Port = 465;
        $this->mail->SMTPDebug = 3;
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    }

    /**
     * @param $username
     * @param $password
     * @param $from string email
     * @param $fromName string name
     * @param $to string|array recipient's email
     * @param $subject
     * @param $message
     * @return void
     */
    public function send($username, $password, $from, $fromName, $to, $subject, $message, $html = 'false')
    {
        try {
            $this->mail->Username = $username;
            $this->mail->Password = $password;
            $this->mail->setFrom($from, $fromName);
            if (is_array($to)) {
                foreach ($to as $recipient) {
                    $this->mail->addAddress($recipient);
                }
            } else {
                $this->mail->addAddress($to);
            }
            $this->mail->Sender = $from;
            if ($html === 'true') {
                $this->mail->isHTML();
            }
            $this->mail->Subject = $subject;
            $this->mail->Body = $message;
            if (!$this->mail->send()) {
                Logging::write_in_csv([
                    [],
                    [print_r($this->mail->ErrorInfo, 1)],
                    ["___________________________________________"]
                ],
                    "logs/mail/" . date('Y-m-d H') . ".csv");
                return "Ошибка: " . $this->mail->ErrorInfo;
            } else {
                Logging::write_in_csv([[], ["Успех"], ["___________________________________________"]],
                    "logs/mail/" . date('Y-m-d H') . ".csv");
                return true;
            }

        } catch (Exception $e) {
            echo $this->mail->ErrorInfo;

        }

    }
}