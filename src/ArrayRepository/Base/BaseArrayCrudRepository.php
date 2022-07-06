<?php

namespace ZnLib\Components\ArrayRepository\Base;

use ZnCore\Domain\Repository\Base\BaseRepository;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;
use ZnLib\Components\ArrayRepository\Traits\ArrayCrudRepositoryTrait;

abstract class BaseArrayCrudRepository extends BaseRepository implements CrudRepositoryInterface
{

    use ArrayCrudRepositoryTrait;
}
