<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Instance\Helpers\InstanceHelper;
use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnCore\Text\Helpers\TemplateHelper;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;
use ZnLib\Console\Domain\Base\BaseShellNew;
use ZnLib\Console\Domain\Libs\IO;

class TaskProcessor
{

    use SingletonTrait;

    public static function runTaskList(array $tasks, IO $io): void
    {
        foreach ($tasks as $taskDefinition) {
            $taskInstance = self::createTask($taskDefinition, $io);
            $title = $taskInstance->getTitle();
            if ($title) {
                $title = TemplateHelper::render($title, $taskDefinition, '{{', '}}');
                $io->writeln($title);
            }
            $taskInstance->run();
        }
    }

    private static function createTask($definition, IO $io): TaskInterface
    {
        $remoteShell = ShellFactory::createRemoteShell();
        return InstanceHelper::create($definition, [
            BaseShellNew::class => $remoteShell,
            IO::class => $io,
        ]);
    }
}
