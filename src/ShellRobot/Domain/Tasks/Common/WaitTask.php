<?php

namespace ZnLib\Components\ShellRobot\Domain\Tasks\Common;

use ZnLib\Components\ShellRobot\Domain\Base\BaseShell;
use ZnLib\Components\ShellRobot\Domain\Interfaces\TaskInterface;

class WaitTask extends BaseShell implements TaskInterface
{

    public $seconds = null;
    protected $title = 'Wait {{seconds}} sec.';

    public function run()
    {
        if(empty($this->seconds)) {
            throw new \Exception('');
        }
        sleep($this->seconds);
    }
}
