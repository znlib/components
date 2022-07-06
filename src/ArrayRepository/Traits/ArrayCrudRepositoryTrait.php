<?php

namespace ZnLib\Components\ArrayRepository\Traits;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Base\Arr\Helpers\FilterHelper;
use ZnCore\Contract\Common\Exceptions\InvalidMethodParameterException;
use ZnCore\Domain\Domain\Traits\DispatchEventTrait;
use ZnCore\Domain\Entity\Exceptions\NotFoundException;
use ZnCore\Domain\Entity\Helpers\EntityHelper;
use ZnCore\Domain\Entity\Interfaces\EntityIdInterface;
use ZnCore\Domain\Query\Entities\Query;
use ZnCore\Domain\Repository\Traits\CrudRepositoryFindAllTrait;
use ZnCore\Domain\Repository\Traits\CrudRepositoryFindOneTrait;

trait ArrayCrudRepositoryTrait
{

    use CrudRepositoryFindAllTrait;
    use CrudRepositoryFindOneTrait;
    use DispatchEventTrait;

    abstract protected function getItems(): array;

    abstract protected function setItems(array $items);

    public function findAll(Query $query = null): Enumerable
    {
        $items = $this->getItems();
        if ($query) {
            $items = FilterHelper::filterItems($items, $query);
        }
        return $this->getEntityManager()->createEntityCollection($this->getEntityClass(), $items);
    }

    public function count(Query $query = null): int
    {
        $collection = $this->findAll($query);
        return $collection->count();
    }

    public function findOneById($id, Query $query = null): EntityIdInterface
    {
        if (empty($id)) {
            throw (new InvalidMethodParameterException('Empty ID'))
                ->setParameterName('id');
        }
        $query = $this->forgeQuery($query);
        $query->where('id', $id);
        return $collection->findOne($query);
    }

    /**
     * @param Query|null $query
     * @return EntityIdInterface
     * @throws NotFoundException
     */
//    public function one(Query $query = null): EntityIdInterface
//    {
//        $query = $this->forgeQuery($query);
//        $query->limit(1);
//        /** @var Collection $collection */
//        $collection = $this->findAll($query);
//        if ($collection->count() == 0) {
//            throw new NotFoundException();
//        }
//        return $collection->first();
//    }

//    public function findOne(Query $query = null): EntityIdInterface
//    {
//        $query = $this->forgeQuery($query);
//        $query->limit(1);
//        /** @var Collection $collection */
//        $collection = $this->findAll($query);
//        if ($collection->count() == 0) {
//            throw new NotFoundException();
//        }
//        return $collection->first();
//    }

    /*public function findOneByUnique(UniqueInterface $entity): EntityIdInterface
    {
        // TODO: Implement findOneByUnique() method.
    }*/

    public function create(EntityIdInterface $entity)
    {
        $items = $this->getItems();
        $items[] = EntityHelper::toArray($entity);
        $this->setItems($items);
    }

    public function update(EntityIdInterface $entity)
    {
        $items = $this->getItems();
        foreach ($items as &$item) {
            if ($entity->getId() == $item['id']) {
                $item = EntityHelper::toArray($entity);
            }
        }
        $this->setItems($items);
    }

    public function deleteById($id)
    {
        $this->deleteByCondition(['id' => $id]);
        /*$items = $this->getItems();
        foreach ($items as &$item) {
            if($entity->getId() == $item['id']) {
                unset($item);
            }
        }
        $this->setItems($items);*/
    }

    public function deleteByCondition(array $condition)
    {
        $items = $this->getItems();
        foreach ($items as &$item) {
            $isMatch = $this->isMatch($item, $condition);
            if ($isMatch) {
                unset($item);
            }
        }
        $this->setItems($items);
    }

    private function isMatch(array $item, array $condition): bool
    {
        foreach ($condition as $conditionAttribute => $conditionValue) {
            if ($item[$conditionAttribute] != $conditionValue) {
                return false;
            }
        }
        return true;
    }
}
