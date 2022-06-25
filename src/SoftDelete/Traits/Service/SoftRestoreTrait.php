<?php

namespace ZnLib\Components\SoftDelete\Traits\Service;

use ZnLib\Components\Status\Enums\StatusEnum;

trait SoftRestoreTrait
{

    public function restoreById($id)
    {
        $entity = $this->oneById($id);
        $entity->restore();
        $this->getRepository()->update($entity);
        return true;
    }
}
