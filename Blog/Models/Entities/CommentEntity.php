<?php


namespace Blog\Models\Entities;


class CommentEntity
{
    private $id;
    private $authorName;
    private $authorEmail;
    private $body;
    private $createdOn;

    public function getId()
    {
        return $this->id;
    }

    public function getAuthorName()
    {
        return $this->authorName;
    }

    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }
}