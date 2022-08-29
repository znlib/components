<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnLib\Components\ShellRobot\Domain\Entities\HostEntity;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;

class ConnectionProcessor
{

//    use SingletonTrait;

    private $currentConnection = 'default';

    public function get(?string $connectionName = null)
    {
        $connectionName = $connectionName ?: $this->getCurrentConnectionName();
        $connection = ShellFactory::getConfigProcessor()->get("connections.$connectionName");
        return $connection;
    }

    public function oneByName(?string $connectionName = null): HostEntity
    {
        $connection = $this->get($connectionName);
        $hostEntity = $this->createEntity($connection);
        return $hostEntity;
    }

    public function switchCurrentConnection(string $connectionName)
    {
        $this->currentConnection = $connectionName;
    }

    public function getCurrent()
    {
        $connectionName = $this->getCurrentConnectionName();
        return $this->get($connectionName);
    }

    private function getCurrentConnectionName()
    {
        return ShellFactory::getVarProcessor()->get('currentConnection', $this->currentConnection);
    }

    private function createEntity(array $connection): HostEntity
    {
        $host = new HostEntity();
        $host->setHost($connection['host'] ?? null);
        $host->setPort($connection['port'] ?? 22);
        $host->setUser($connection['user'] ?? null);
        return $host;
    }
}
