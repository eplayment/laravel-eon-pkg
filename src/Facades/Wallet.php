<?php

namespace Eplayment\Wallet\Facades;

use Illuminate\Support\Facades\Facade;

class Wallet extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Wallet';
    }
}
