<?php

namespace ZnLib\Components\SoftDelete\Traits\Service;

use ZnLib\Components\Status\Enums\StatusEnum;

trait SoftDeleteTrait
{

    public function deleteById($id)
    {
        $entity = $this->oneById($id);
        $entity->delete();
        $this->getRepository()->update($entity);
        return true;
    }
}
