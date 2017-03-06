<?php


namespace Framework\Core\Session;


interface SessionInterface
{
    public function setProperty(string $name, $value);

    public function unsetProperty(string $name);

    public function propertyExists(string $name): bool;

    public function getProperty(string $name);

    public function addMessage(string $text, int $type);

    public function getMessages(): array;

    public function getMessagesCount(int $type): int;

    public function flushMessages();

    public function destroy();
}