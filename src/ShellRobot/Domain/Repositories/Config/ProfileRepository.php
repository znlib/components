<?php

namespace ZnLib\Components\ShellRobot\Domain\Repositories\Config;

use ZnLib\Components\ShellRobot\Domain\Libs\App\ConfigProcessor;

class ProfileRepository
{

    public static function findOneByName(string $projectName)
    {
        $profiles = self::findAll();
        $profileConfig = $profiles[$projectName];
        return $profileConfig;
    }

    public static function findAll()
    {
        $profiles = ConfigProcessor::get('profiles');
        $new = [];
        foreach ($profiles as $profileName => $profileConfig) {
            if (!is_string($profileName)) {
                $hash = hash('sha256', $profileName);
                $profileName = $profileConfig['name'] ?? $hash;
            }
            $profileConfig['name'] = $profileName;
            $new[$profileName] = $profileConfig;
        }
        return $new;
    }
}
