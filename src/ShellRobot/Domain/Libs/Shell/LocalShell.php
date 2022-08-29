<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\Shell;

use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Console\Domain\Base\BaseShellNew;

class LocalShell extends BaseShellNew
{

    protected function prepareCommandString(string $commandString): string
    {
        $commandString = ShellFactory::getVarProcessor()->process($commandString);
        return $commandString;
    }
}
