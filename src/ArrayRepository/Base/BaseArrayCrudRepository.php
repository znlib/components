<?php

namespace ZnLib\Components\ArrayRepository\Base;

use ZnCore\Repository\Base\BaseRepository;
use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnLib\Components\ArrayRepository\Traits\ArrayCrudRepositoryTrait;

abstract class BaseArrayCrudRepository extends BaseRepository implements CrudRepositoryInterface
{

    use ArrayCrudRepositoryTrait;
}
