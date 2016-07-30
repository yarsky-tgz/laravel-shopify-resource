<?php

namespace Yarsky\Shopify\Facades;

use Illuminate\Support\Facades\Facade;

class Sh extends Facade
{
    protected static function getFacadeAccessor() { return 'Shopify'; }
}
