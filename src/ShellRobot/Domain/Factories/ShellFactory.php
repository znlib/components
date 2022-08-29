<?php

namespace ZnLib\Components\ShellRobot\Domain\Factories;

use ZnCore\Container\Helpers\ContainerHelper;
use ZnCore\Instance\Helpers\InstanceHelper;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConfigProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConnectionProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\Shell\RemoteShell;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;

class ShellFactory
{

    public static function getVarProcessor(): VarProcessor
    {
        return ContainerHelper::getContainer()->get(VarProcessor::class);
    }

    public static function getConfigProcessor(): ConfigProcessor
    {
        return ContainerHelper::getContainer()->get(ConfigProcessor::class);
    }

    public static function getConnectionProcessor(): ConnectionProcessor
    {
        return ContainerHelper::getContainer()->get(ConnectionProcessor::class);
    }

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
        $hostEntity = ShellFactory::getConnectionProcessor()->oneByName($connectionName);
        $remoteShell = new RemoteShell($hostEntity);
        return $remoteShell;
    }
}
