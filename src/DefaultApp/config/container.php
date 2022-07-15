<?php

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use ZnDomain\Validator\Libs\Validators\ChainValidator;
use ZnDomain\Validator\Libs\Validators\ClassMetadataValidator;
use ZnLib\Components\DynamicEntity\Libs\Validators\DynamicEntityValidator;

return [
    'singletons' => [
        LoggerInterface::class => NullLogger::class,
        AdapterInterface::class => ArrayAdapter::class,
        CacheInterface::class => AdapterInterface::class,
        ChainValidator::class => function (ContainerInterface $container) {
            /** @var ChainValidator $chainValidator */
            $chainValidator = new ChainValidator($container);
            $chainValidator->setValidators([
                ClassMetadataValidator::class,
                DynamicEntityValidator::class,
            ]);
            return $chainValidator;
        }
    ],
];
