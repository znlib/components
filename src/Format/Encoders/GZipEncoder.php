<?php

namespace ZnLib\Components\Format\Encoders;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;

/**
 * Сжатие данных GZip
 */
class GZipEncoder implements EncoderInterface
{

    private $encoding;
    private $level;

    public function __construct(int $encoding = ZLIB_ENCODING_GZIP, int $level = -1)
    {
        $this->encoding = $encoding;
        $this->level = $level;
    }

    public function encode($data)
    {
        return gzcompress($data, $this->level, $this->encoding);
    }

    public function decode($encodedData)
    {
        if($this->encoding == ZLIB_ENCODING_GZIP) {
            return gzdecode($encodedData);
        } elseif($this->encoding == ZLIB_ENCODING_DEFLATE) {
            return gzinflate($encodedData);
        } elseif($this->encoding == ZLIB_ENCODING_RAW) {
            return gzinflate($encodedData);
        }
    }
}