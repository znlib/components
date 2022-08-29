<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnCore\Text\Helpers\TemplateHelper;

class VarProcessor
{

    use SingletonTrait;

    private static $vars;

    public function process(string $value): string
    {
//        self::init();
        return $this->render($value, self::$vars);
    }

    public function processList(array $list): array
    {
        $callback = [static::class, 'process'];
        $list = array_map($callback, $list);
        return $list;
    }

    public function set(string $key, $value): void
    {
//        self::init();
        ArrayHelper::set(self::$vars, $key, $value);
        $this->initVars();
    }

    public function setList(array $list): void
    {
//        self::init();
        foreach ($list as $key => $value) {
            ArrayHelper::set(self::$vars, $key, $value);
        }
        $this->initVars();
    }

    public function get(string $key, $default = null)
    {
        return ArrayHelper::getValue(self::$vars, $key, $default);
    }

    private function render($value, $vars)
    {
        return TemplateHelper::render($value, $vars, '{{', '}}');
    }

    public function setVars(array $vars): void
    {
        self::$vars = $vars;
        $this->initVars();
    }

    /*private static function init()
    {
        if (self::$vars) {
            return;
        }
//        $config = include($_ENV['DEPLOYER_CONFIG_FILE']);
//        self::$vars = $config['vars'];

//        self::$vars = ConfigProcessor::get('vars');
    }*/

    private function initVars()
    {
        self::$vars = $this->processVars(self::$vars);
    }

    private function processVars($vars)
    {
        do {
            $oldVars = $vars;
            foreach ($vars as $index => $var) {
                $vars[$index] = $this->render($var, $vars);
            }
        } while ($oldVars !== $vars);
        return $vars;
    }
}
