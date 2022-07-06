<?php

namespace ZnLib\Components\Status\Enums;

use ZnLib\Components\I18Next\Facades\I18Next;
use ZnCore\Enum\Interfaces\GetLabelsInterface;

/**
 * Статусы сущности (сокращенный вариант)
 */
class StatusSimpleEnum implements GetLabelsInterface
{

    const ENABLED = 100;
    const DISABLED = 0;
    const DELETED = self::DISABLED;

    public static function getLabels()
    {
        return [
            self::ENABLED => I18Next::t('core', 'status.enabled'),
            self::DISABLED => I18Next::t('core', 'status.disabled'),
        ];
    }
}