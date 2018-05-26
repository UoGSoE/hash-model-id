<?php

namespace Tests;

use UoGSoE\ModelHashIds\CanHashUserIds;

class FakeUser
{
    use CanHashUserIds;

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}