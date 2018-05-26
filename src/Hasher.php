<?php

namespace UoGSoE\ModelHashIds;

use Hashids\Hashids;

class Hasher
{
    protected $hashIds;

    public function __construct()
    {
        $this->hashIds = new Hashids(config('app.key'), 6);
    }

    public function generate($value)
    {
        return $this->hashIds->encode($value);
    }

    public function decode($hash)
    {
        return $this->hashIds->decode($hash)[0];
    }
}