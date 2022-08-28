<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnLib\Components\ShellRobot\Domain\Entities\HostEntity;

class ConnectionProcessor
{

    use SingletonTrait;

    public static function get(?string $connectionName = null)
    {
        $connectionName = $connectionName ?: self::getCurrentConnectionName();
        $connection = ConfigProcessor::get("connections.$connectionName");
        return $connection;
    }

    public static function getCurrent()
    {
        $connectionName = self::getCurrentConnectionName();
        return self::get($connectionName);
    }

    public static function getCurrentConnectionName(string $defaultConnectionName = 'default')
    {
        return VarProcessor::get('currentConnection', $defaultConnectionName);
    }

    public static function createEntity(array $connection): HostEntity
    {
        $host = new HostEntity();
        $host->setHost($connection['host'] ?? null);
        $host->setPort($connection['port'] ?? 22);
        $host->setUser($connection['user'] ?? null);
        return $host;
    }
}
