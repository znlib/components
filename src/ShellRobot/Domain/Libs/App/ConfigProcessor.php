<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;

class ConfigProcessor
{

    use SingletonTrait;

    private static $config;

    public function get(string $key, $default = null)
    {
//        self::init();
        $value = ArrayHelper::getValue(self::$config, $key, $default);
        if (is_string($value)) {
            $value = ShellFactory::getVarProcessor()->process($value);
        }
        return $value;
    }

    public function all()
    {
//        self::init();
        return self::$config;
    }

    public function setConfig(array $config): void
    {
        self::$config = $config;
    }

    /*private static function init()
    {
        if (self::$config) {
            return;
        }
//        self::$config = include($_ENV['DEPLOYER_CONFIG_FILE']);
    }*/
}
