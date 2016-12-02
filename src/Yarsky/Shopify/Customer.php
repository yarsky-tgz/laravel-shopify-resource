<?php

namespace Yarsky\Shopify;

class Customer extends Resource
{
    use Trait\Searchable;
    const RESOURCE_NAME_MULT = 'customers';
    const RESOURCE_NAME = 'customer';

    public static function exists($email)
    {
        $customers = static::search([
            'query' => 'email:' . $email,
            'fields' => 'id',
            'limit' => 1
        ]);
        return (bool) $customers->count();
    }
}
