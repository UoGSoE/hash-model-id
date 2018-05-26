<?php

namespace UoGSoE\ModelHashIds;

use UoGSoE\ModelHashIds\Hasher as UogSoeHasher;

trait CanHashUserIds
{
    public function getIdHashAttribute()
    {
        return (new UogSoeHasher)->generate($this->id);
    }
}
