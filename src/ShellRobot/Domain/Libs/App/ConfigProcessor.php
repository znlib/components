<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;

class ConfigProcessor
{

//    use SingletonTrait;

    private $config;

    public function get(string $key, $default = null)
    {
        $value = ArrayHelper::getValue($this->config, $key, $default);
        if (is_string($value)) {
            $value = ShellFactory::getVarProcessor()->process($value);
        }
        return $value;
    }

    /*public function all()
    {
        return $this->config;
    }*/

    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
