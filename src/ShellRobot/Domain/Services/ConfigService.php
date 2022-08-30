<?php

namespace ZnLib\Components\ShellRobot\Domain\Services;

use ZnDomain\EntityManager\Interfaces\EntityManagerInterface;
use ZnDomain\Service\Base\BaseService;
use ZnLib\Components\ShellRobot\Domain\Interfaces\Repositories\ConfigRepositoryInterface;
use ZnLib\Components\ShellRobot\Domain\Interfaces\Services\ConfigServiceInterface;

/**
 * @method ConfigRepositoryInterface getRepository()
 */
class ConfigService extends BaseService implements ConfigServiceInterface
{

    public function __construct(EntityManagerInterface $em, ConfigRepositoryInterface $configRepository)
    {
        $this->setEntityManager($em);
        $this->setRepository($configRepository);
    }

    public function getEntityClass(): string
    {
        return ConfigEntity::class;
    }

    public function get(string $key, $default = null)
    {
        return $this->getRepository()->get($key, $default);
    }
}
