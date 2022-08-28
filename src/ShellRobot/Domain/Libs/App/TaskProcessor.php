<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnCore\Text\Helpers\TemplateHelper;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;

class TaskProcessor
{

    use SingletonTrait;

    public static function runTaskList(array $tasks, $io): void
    {
        foreach ($tasks as $task) {
            $taskInstance = ShellFactory::createTask($task, $io);
            $title = $taskInstance->getTitle();
            if ($title) {
                $title = TemplateHelper::render($title, $task, '{{', '}}');
                $io->writeln($title);
            }
            $taskInstance->run();
        }
    }
}
