<?php

namespace App\Messages;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use App\Messages\ContactNotification;

class SendNotificationHandler implements MessageHandlerInterface

{
    private $mailer; 
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(ContactNotification $notification)
    {
        $email = (new TemplatedEmail())
        ->from($notification->getEmail())
        ->to('samoudiayman777@gmail.com')
        ->subject($notification->getSubject())
        ->htmlTemplate('email/emailTemplate.html.twig')
        ->context([
            'telephone' => $notification->getTelephone(),
            'memail' => $notification->getEmail(),
            'message' => $notification->getMessage(),
        ]);
       $this->mailer->send($email);

    }
}