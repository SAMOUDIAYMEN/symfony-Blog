<?php

namespace App\Model;

interface TimestampedInterface
{

    public function getCreatedAt(): ?\DateTimeInterface;

    public function setCreatedAt(\DateTimeInterface $createdAt): self;

    public function getUpdateAt(): ?\DateTimeInterface;

    public function setUpdateAt(\DateTimeInterface $modifiedAt): self;
}