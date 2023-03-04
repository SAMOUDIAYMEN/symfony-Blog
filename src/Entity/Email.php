<?php

namespace App\Entity;

use App\Repository\EmailRepository;
use Doctrine\ORM\Mapping as ORM; 
use App\Model\TimestampableTrait;

#[ORM\Entity(repositoryClass: EmailRepository::class)]
class Email
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $resivedFrom = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 2000)]
    private ?string $message = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isviewed = null;


    public function __construct(){
        $this->createdAt = new \DateTime('@'.strtotime('now'));
        $this->updateAt = new \DateTime('@'.strtotime('now'));
        $this->isviewed = false;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResivedFrom(): ?string
    {
        return $this->resivedFrom;
    }

    public function setResivedFrom(string $resivedFrom): self
    {
        $this->resivedFrom = $resivedFrom;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function isIsviewed(): ?bool
    {
        return $this->isviewed;
    }

    public function setIsviewed(?bool $isviewed): self
    {
        $this->isviewed = $isviewed;

        return $this;
    }
}
