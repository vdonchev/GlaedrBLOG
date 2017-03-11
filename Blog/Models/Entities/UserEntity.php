<?php


namespace Blog\Models\Entities;


class UserEntity
{
    private $id;
    private $username;
    private $password;
    private $name;
    private $email;
    private $roleId;
    private $role;
    private $templateName;
    private $templateFile;
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

    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getTemplateName()
    {
        return $this->templateName;
    }
}