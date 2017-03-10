<?php


namespace Blog\Models\Entities;


class TemplateEntity
{
    private $id;
    private $name;
    private $cssFile;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCssFile()
    {
        return $this->cssFile;
    }
}