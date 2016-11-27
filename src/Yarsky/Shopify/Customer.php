<?php

namespace Yarsky/Shopify;

use Sh;

class Customer extends Resource
{
    use Trait/Searchable;
    const RESOURCE_NAME_MULT = 'customers';
    const RESOURCE_NAME = 'customer';
}
