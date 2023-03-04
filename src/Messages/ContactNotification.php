<?php

namespace App\Messages;

class ContactNotification
{ 
    private ?string $subject = null;
    private ?string $email = null;
    private ?string $telephone = null;
    private ?string $message = null;

    public function __construct(string $subject, string $email,string $telephone,string $message)
    { 
        $this->subject = $subject;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->message = $message;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function getMessage()
    {
        return $this->message;
    }
}