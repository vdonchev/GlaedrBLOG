<?php


namespace Blog\Models\Entities;


class UserEntity
{
    private $id;
    private $username;
    private $password;
    private $roleId;
    private $role;
    private $createdOn;
    private $updatedOn;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }
}