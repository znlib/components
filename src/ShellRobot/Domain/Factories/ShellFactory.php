<?php

namespace ZnLib\Components\ShellRobot\Domain\Factories;

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

    private static $varProcessor;
    private static $configProcessor;

    private static function initVarProcessor(VarProcessor $varProcessor)
    {
        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
        $vars = $config['vars'];
        $vars['userName'] = $config['connections']['default']['user'];
        $vars['homeUserDir'] = "/home/{$vars['userName']}";
//        ConfigProcessor::getInstance()->setConfig($config);
        $varProcessor->setVars($vars);
    }

    private static function initConfigProcessor(ConfigProcessor $configProcessor)
    {
        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
//        $vars = $config['vars'];
//        $vars['userName'] = $config['connections']['default']['user'];
//        $vars['homeUserDir'] = "/home/{$vars['userName']}";
        $configProcessor->setConfig($config);
//        VarProcessor::getInstance()->setVars($vars);
    }

    public static function getVarProcessor(): VarProcessor
    {
        if (!isset(self::$varProcessor)) {
            self::$varProcessor = VarProcessor::getInstance();
            self::initVarProcessor(self::$varProcessor);
        }
        return self::$varProcessor;
    }

    public static function getConfigProcessor(): ConfigProcessor
    {
        if (!isset(self::$configProcessor)) {
            self::$configProcessor = ConfigProcessor::getInstance();
            self::initConfigProcessor(self::$configProcessor);
        }
        return self::$configProcessor;
    }

    public static function getConnectionProcessor(): ConnectionProcessor
    {
        return ConnectionProcessor::getInstance();
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
        $connection = ShellFactory::getConnectionProcessor()->get($connectionName);
        $hostEntity = ShellFactory::getConnectionProcessor()->createEntity($connection);
        $remoteShell = new RemoteShell($hostEntity);
        return $remoteShell;
    }
}
