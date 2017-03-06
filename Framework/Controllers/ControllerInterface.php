<?php


namespace Framework\Controllers;


use Framework\Models\ModelInterface;

interface ControllerInterface
{
    public function onInitialize();

    public function getRequest();

    public function getModel(): ModelInterface;

    public function renderView(string $view, bool $includeTemplate = true);

    public function addData(string $key, $data);

    public function getData(): array;

    public function isAuthorized(): bool;

    public function isAdmin(): bool;
}