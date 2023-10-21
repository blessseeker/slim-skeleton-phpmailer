<?php

declare(strict_types=1);

namespace App\Application\Actions\Email;

use Psr\Http\Message\ResponseInterface as Response;
use PHPMailer\PHPMailer\Exception;

class SendEmailAction extends EmailAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->logger->info("Send Email Triggered.");
        
        $response = [];
        try {
            $request = $this->getFormData();
            //Sender and recipient
            $this->mail->setFrom($request['mail']['sender']['email'], $request['mail']['sender']['name']);
            $this->mail->addAddress($request['mail']['recipient']['email'], $request['mail']['recipient']['name']);
        
            $this->mail->isHTML(true);
            $this->mail->Subject = $request['mail']['subject'];
            $this->mail->Body    = $request['mail']['content'];
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $this->mail->send();
            $response['sent'] = true;
            $response['message'] = 'Email has been sent successfully.';
        } catch (Exception $e) {
            $response['sent'] = false;
            $response['message'] = 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
        }

        $this->logger->info(json_encode($response));
        return $this->respondWithData($response);
    }
}
