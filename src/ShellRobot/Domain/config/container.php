<?php

use Psr\Container\ContainerInterface;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConfigProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\ConnectionProcessor;
use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;

return [
    'singletons' => [
        VarProcessor::class => function (ContainerInterface $container) {
            $varProcessor = new VarProcessor();
            $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
            $vars = $config['vars'];
            $vars['userName'] = $config['connections']['default']['user'];
            $vars['homeUserDir'] = "/home/{$vars['userName']}";
            $varProcessor->setVars($vars);
            return $varProcessor;
        },
        ConfigProcessor::class => function (ContainerInterface $container) {
            $configProcessor = new ConfigProcessor();
            $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
            $configProcessor->setConfig($config);
            return $configProcessor;
        },
        ConnectionProcessor::class => function (ContainerInterface $container) {
            $configProcessor = new ConnectionProcessor();
            return $configProcessor;
        },
    ],
];
