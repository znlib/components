<?php

namespace ZnLib\Components\ShellRobot\Domain\Factories;

use ZnCore\Instance\Helpers\InstanceHelper;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConnectionProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\Shell\RemoteShell;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;

class ShellFactory
{

    public static function createTask($definition, IO $io): TaskInterface
    {
        $remoteShell = ShellFactory::createRemoteShell();
        return InstanceHelper::create($definition, [
            BaseShellNew::class => $remoteShell,
            IO::class => $io,
        ]);
    }

    public static function createRemoteShell(?string $connectionName = null): RemoteShell
    {
        $connection = ConnectionProcessor::get($connectionName);
        $hostEntity = ConnectionProcessor::createEntity($connection);
        $remoteShell = new RemoteShell($hostEntity);
        return $remoteShell;
    }
}
