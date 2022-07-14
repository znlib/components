<?php

namespace ZnLib\Components\Author\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnUser\Authentication\Domain\Interfaces\Services\AuthServiceInterface;
use ZnDomain\Domain\Enums\EventEnum;
use ZnDomain\Domain\Events\QueryEvent;
use ZnDomain\EntityManager\Interfaces\EntityManagerInterface;
use ZnDomain\EntityManager\Traits\EntityManagerAwareTrait;

class AuthorQuerySubscriber implements EventSubscriberInterface
{

    use EntityManagerAwareTrait;

    private $authService;
    private $attributeName;

    public function __construct(EntityManagerInterface $entityManager, AuthServiceInterface $authService)
    {
        $this->setEntityManager($entityManager);
        $this->authService = $authService;
    }

    public function setAttributeName(string $attributeName): void
    {
        $this->attributeName = $attributeName;
    }

    public static function getSubscribedEvents()
    {
        return [
            EventEnum::BEFORE_FORGE_QUERY => 'onBeforeForgeQuery',
        ];
    }

    public function onBeforeForgeQuery(QueryEvent $event)
    {
        $query = $event->getQuery();
        $identityId = $this->authService->getIdentity()->getId();
        $query->where($this->attributeName, $identityId);
    }
}
