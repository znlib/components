<?php

namespace ZnLib\Components\ShellRobot\Domain\Interfaces;

interface TaskInterface
{

    public function run();

    public function getTitle(): ?string;
}
