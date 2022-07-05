<?php

namespace ZnLib\Components\Format\Encoders;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Collection\Libs\Collection;
use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;
use ZnCore\Base\Instance\Helpers\InstanceHelper;

/**
 * Агрегатный кодер
 * 
 * Содержит в себе инстансы других кодеров.
 * 
 * При кодировании/декодировании вызывает соответствующие методы вложенных кодеров.
 * Агрегатный кодер пригодится, когда необходимо реализовать "матрешку" из форматов, например - .tar.gz
 *
 * @todo переименовать в ChainEncoder
 */
class ChainEncoder implements EncoderInterface
{

    /**
     * @var Collection|EncoderInterface[] Коллекция кодеров
     */
    private $encoderCollection;

    /**
     * ChainEncoder constructor.
     * @param Collection|EncoderInterface[] $encoderCollection Коллекция кодеров
     */
    public function __construct(Collection $encoderCollection)
    {
        $this->encoderCollection = $encoderCollection;
    }

    /**
     * Получить коллекцию кодеров
     * @return Collection|EncoderInterface[] Коллекция кодеров
     */
    public function getEncoders(): Enumerable
    {
        return $this->encoderCollection;
    }

    public function encode($data)
    {
        $encoders = $this->encoderCollection->toArray();
        foreach ($encoders as $encoderClass) {
            $encoderInstance = $this->getEncoderInstance($encoderClass);
            $data = $encoderInstance->encode($data);
        }
        return $data;
    }

    public function decode($data)
    {
        $encoders = $this->encoderCollection->toArray();
        $encoders = array_reverse($encoders);
        foreach ($encoders as $encoderClass) {
            $encoderInstance = $this->getEncoderInstance($encoderClass);
            $data = $encoderInstance->decode($data);
        }
        return $data;
    }

    /**
     * Создать инстанс кодера
     * @param string|array $encoderClass Описание инстанса
     * @return EncoderInterface
     */
    private function getEncoderInstance($encoderClass): EncoderInterface
    {
        return InstanceHelper::ensure($encoderClass);
    }
}
