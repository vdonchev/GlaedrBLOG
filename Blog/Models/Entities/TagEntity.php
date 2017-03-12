<?php


namespace Blog\Models\Entities;


class TagEntity
{
    private $id;
    private $name;
    private $popularity;
    private $minPopularity;
    private $maxPopularity;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPopularity()
    {
        return $this->popularity;
    }

    public function getPopularityRatio(): float
    {
        return ($this->popularity - $this->minPopularity) / ($this->maxPopularity - $this->minPopularity);
    }
}