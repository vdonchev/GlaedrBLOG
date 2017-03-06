<?php


namespace Framework\Core\Utilities;


class Messages
{
    private function __construct()
    {
    }

    const SUCCESS = 0;
    const INFO = 1;
    const DANGER = 2;

    public static function typeExists(int $type): bool
    {
        $reflection = new \ReflectionClass(self::class);

        return in_array($type, array_values($reflection->getConstants()));
    }

    public static function getTypeName(int $type): string
    {
        $reflection = new \ReflectionClass(self::class);

        return strtolower(array_flip($reflection->getConstants())[$type]);
    }
}