<?php


namespace Blog\Models\Entities;


class GuestEntity
{
    private $id;
    private $name;
    private $email;
    private $ip;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getIp()
    {
        return $this->ipToReadable();
    }

    private function ipToReadable(): string
    {
        return inet_ntop($this->ip);
    }
}