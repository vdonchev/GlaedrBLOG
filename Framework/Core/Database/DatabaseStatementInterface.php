<?php


namespace Framework\Core\Database;


interface DatabaseStatementInterface
{
    public function execute(array $params = []);

    public function fetchRow();

    public function fetchAll();

    public function fetchObj($className = \stdClass::class);
}