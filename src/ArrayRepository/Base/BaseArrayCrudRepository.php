<?php

namespace ZnLib\Components\ArrayRepository\Base;

use ZnDomain\Repository\Base\BaseRepository;
use ZnDomain\Repository\Interfaces\CrudRepositoryInterface;
use ZnLib\Components\ArrayRepository\Traits\ArrayCrudRepositoryTrait;

abstract class BaseArrayCrudRepository extends BaseRepository implements CrudRepositoryInterface
{

    use ArrayCrudRepositoryTrait;
}
