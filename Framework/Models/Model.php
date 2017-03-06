<?php


namespace Framework\Models;


use Framework\Core\Database\DatabaseInterface;

abstract class Model implements ModelInterface
{
    private $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    protected function getDb(): DatabaseInterface
    {
        return $this->db;
    }
}