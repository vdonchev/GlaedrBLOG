<?php


namespace Blog\Models\Entities;


class PostEntity
{
    private $id;
    private $author;
    private $title;
    private $body;
    private $createdOn;
    private $updatedOn;

    private $tags = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getCreatedOn(): string
    {
        return $this->createdOn;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
    }
}