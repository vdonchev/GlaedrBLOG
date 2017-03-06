<?php


namespace Framework\Core\Database;


interface DatabaseInterface
{
    public function prepare(string $query): DatabaseStatementInterface;

    public function getLastId(string $name = null);
}