<?php

namespace ZnLib\Components\Store\Base;

use ZnLib\Components\ArrayRepository\Traits\ArrayCrudRepositoryTrait;
use ZnCore\DotEnv\Domain\Libs\DotEnv;
use ZnCore\FileSystem\Helpers\FilePathHelper;
use ZnCore\Query\Entities\Query;
use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnLib\Components\Store\StoreFile;

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

    protected function forgeQuery(Query $query = null): Query
    {
        $query = Query::forge($query);
        return $query;
    }

    public function fileName(): string
    {
        $tableName = $this->tableName();
//        $root = FilePathHelper::rootPath();
        $directory = $this->directory();
        $ext = $this->fileExt();
        $path = "$directory/$tableName.$ext";
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
