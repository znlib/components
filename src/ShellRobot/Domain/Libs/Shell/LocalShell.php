<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\Shell;

use ZnLib\Components\ShellRobot\Domain\Libs\App\VarProcessor;
use ZnLib\Console\Domain\Base\BaseShellNew;

class LocalShell extends BaseShellNew
{

    protected function prepareCommandString(string $commandString): string
    {
        $commandString = VarProcessor::process($commandString);
        return $commandString;
    }
}
