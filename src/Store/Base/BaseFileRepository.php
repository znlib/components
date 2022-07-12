<?php

namespace ZnLib\Components\Store\Base;

use ZnCore\Contract\Common\Exceptions\NotImplementedMethodException;
use ZnCore\DotEnv\Domain\Libs\DotEnv;
use ZnCore\FileSystem\Helpers\FilePathHelper;
use ZnLib\Components\Store\StoreFile;
use ZnCore\EntityManager\Interfaces\EntityManagerInterface;
use ZnCore\Repository\Interfaces\RepositoryInterface;
use ZnCore\EntityManager\Traits\EntityManagerAwareTrait;

abstract class BaseFileRepository implements RepositoryInterface
{

    use EntityManagerAwareTrait;

    public function __construct(EntityManagerInterface $em)
    {
        $this->setEntityManager($em);
    }

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
        // todo: cache data
        $store = new StoreFile($this->fileName());
        return $store->load() ?: [];
    }

    protected function setItems(array $items)
    {
        $store = new StoreFile($this->fileName());
        return $store->save($items);
    }
}
