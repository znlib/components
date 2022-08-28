<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Pattern\Singleton\SingletonTrait;

class ConfigProcessor
{

    use SingletonTrait;

    private static $config;

    public static function get(string $key, $default = null)
    {
        self::init();
        $value = ArrayHelper::getValue(self::$config, $key, $default);
        if (is_string($value)) {
            $value = VarProcessor::process($value);
        }
        return $value;
    }

    public static function all()
    {
        self::init();
        return self::$config;
    }

    private static function init()
    {
        if (self::$config) {
            return;
        }
        self::$config = include($_ENV['DEPLOYER_CONFIG_FILE']);
    }
}
