<?php

declare(strict_types=1);

namespace App\Application\Actions\Email;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use PHPMailer\PHPMailer\PHPMailer;

abstract class EmailAction extends Action
{
    protected $mail;
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
        $this->mail = new PHPMailer(true);
        //Server settings
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = '';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = '';                     //SMTP username
        $this->mail->Password   = '';                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }
}
