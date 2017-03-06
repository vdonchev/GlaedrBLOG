<?php


namespace Framework\Models;


use Framework\Core\Database\DatabaseInterface;

interface ModelInterface
{
    public function isAdmin(int $id): bool;
}