<?php

namespace ZnLib\Components\ShellRobot\Domain\Services;

use ZnLib\Components\ShellRobot\Domain\Entities\HostEntity;
use ZnLib\Components\ShellRobot\Domain\Factories\ShellFactory;
use ZnLib\Components\ShellRobot\Domain\Interfaces\Services\ConnectionServiceInterface;
use ZnLib\Components\ShellRobot\Domain\Interfaces\Repositories\ConnectionRepositoryInterface;
use ZnDomain\Service\Base\BaseService;
use ZnDomain\EntityManager\Interfaces\EntityManagerInterface;

/**
 * @method ConnectionRepositoryInterface getRepository()
 */
class ConnectionService extends BaseService implements ConnectionServiceInterface
{

    public function __construct(EntityManagerInterface $em, ConnectionRepositoryInterface $connectionRepository)
    {
        $this->setEntityManager($em);
        $this->setRepository($connectionRepository);
    }

    public function getEntityClass() : string
    {
        return ConnectionEntity::class;
    }

    public function get(?string $connectionName = null)
    {
        return $this->getRepository()->get($connectionName);
    }

    public function oneByName(?string $connectionName = null): HostEntity
    {
        return $this->getRepository()->oneByName($connectionName);
    }

    public function getCurrent()
    {
        return $this->getRepository()->getCurrent();
    }
}

