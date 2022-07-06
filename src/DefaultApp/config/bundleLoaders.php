<?php

use ZnCore\Container\Libs\BundleLoaders\ContainerLoader;
use ZnDatabase\Migration\Domain\Libs\BundleLoaders\MigrationLoader;
use ZnLib\Components\I18Next\Libs\BundleLoaders\I18NextLoader;
use ZnUser\Rbac\Domain\Libs\BundleLoaders\RbacConfigLoader;

return [
    'container' => ContainerLoader::class,
    'i18next' => I18NextLoader::class,
    'rbac' => RbacConfigLoader::class,
    'migration' => MigrationLoader::class,
];
