<?php

namespace ZnLib\Components\CommonTranslate;

use ZnCore\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{

    public function i18next(): array
    {
        return [
            'core' => 'vendor/znlib/components/src/CommonTranslate/i18next/__lng__/__ns__.json',
        ];
    }
}
