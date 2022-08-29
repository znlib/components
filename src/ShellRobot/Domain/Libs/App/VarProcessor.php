<?php

namespace ZnLib\Components\ShellRobot\Domain\Libs\App;

use ZnCore\Arr\Helpers\ArrayHelper;
use ZnCore\Pattern\Singleton\SingletonTrait;
use ZnCore\Text\Helpers\TemplateHelper;

class VarProcessor
{

//    use SingletonTrait;

    private $vars;

    public function process(string $value): string
    {
        return $this->render($value, $this->vars);
    }

    public function processList(array $list): array
    {
        $callback = [$this, 'process'];
        $list = array_map($callback, $list);
        return $list;
    }

    public function set(string $key, $value): void
    {
        ArrayHelper::set($this->vars, $key, $value);
        $this->initVars();
    }

    public function setList(array $list): void
    {
        foreach ($list as $key => $value) {
            ArrayHelper::set($this->vars, $key, $value);
        }
        $this->initVars();
    }

    public function get(string $key, $default = null)
    {
        return ArrayHelper::getValue($this->vars, $key, $default);
    }

    private function render($value, $vars)
    {
        return TemplateHelper::render($value, $vars, '{{', '}}');
    }

    public function setVars(array $vars): void
    {
        $this->vars = $vars;
        $this->initVars();
    }

    private function initVars()
    {
        $this->vars = $this->processVars($this->vars);
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
