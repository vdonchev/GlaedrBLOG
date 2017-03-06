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

    public function isAdmin(int $id): bool
    {
        $stmt = $this->getDb()->prepare("SELECT users.roleId FROM users WHERE id = ?");
        $stmt->execute([$id]);

        return intval($stmt->fetchRow()["roleId"]) === 1;
    }
}