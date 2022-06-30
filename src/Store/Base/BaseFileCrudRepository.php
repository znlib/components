<?php

namespace ZnLib\Components\Store\Base;

use ZnCore\Contract\Common\Exceptions\NotImplementedMethodException;
use ZnCore\Base\Arr\Traits\ArrayCrudRepositoryTrait;
use ZnCore\Base\DotEnv\Domain\Libs\DotEnv;
use ZnCore\Base\FileSystem\Helpers\FilePathHelper;
use ZnCore\Domain\Domain\Traits\FindAllTrait;
use ZnCore\Domain\Domain\Traits\FindOneTrait;
use ZnCore\Domain\Query\Entities\Query;
use ZnLib\Components\Store\StoreFile;
use ZnCore\Domain\Repository\Interfaces\CrudRepositoryInterface;

abstract class BaseFileCrudRepository extends BaseFileRepository implements CrudRepositoryInterface
{

    use ArrayCrudRepositoryTrait;


    /*public function tableName(): string
    {
        throw new NotImplementedMethodException('Not Implemented Method "tableName"');
    }*/

    public function directory(): string
    {
        return DotEnv::get('FILE_DB_DIRECTORY');
    }

    public function fileExt(): string
    {
        return 'php';
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = Query::forge($query);
        return $query;
    }

    public function fileName(): string
    {
        $tableName = $this->tableName();
        $root = FilePathHelper::rootPath();
        $directory = $this->directory();
        $ext = $this->fileExt();
        $path = "$root/$directory/$tableName.$ext";
        return $path;
    }

    protected function getItems(): array
    {
        $store = new StoreFile($this->fileName());
        return $store->load() ?: [];
    }

    protected function setItems(array $items)
    {
        $store = new StoreFile($this->fileName());
        $store->save($items);
    }
}
