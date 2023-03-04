<?php

namespace App\Service;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use App\Messages\ContactNotification;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Entity\Email as Contact;
use Symfony\Component\Messenger\Envelope;

class EmailService
{
    private MessageBusInterface $bus;
    public function __construct(MessageBusInterface $bus) {
        $this->bus = $bus;
    }
    public function sendEmail(?Contact $contact): Envelope
    {
        $result = $this->bus->dispatch(new ContactNotification(
            $contact->getSubject(),
            $contact->getResivedFrom(),
            $contact->getPhone(),
            $contact->getMessage())
        );

        return $result;
    }
}