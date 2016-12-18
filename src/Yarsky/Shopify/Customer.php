<?php

namespace Yarsky\Shopify;

class Customer extends Resource
{
    const RESOURCE_NAME_MULT = 'customers';
    const RESOURCE_NAME = 'customer';

    public static function search($options = array())
    {
        $results =  static::call([
            'METHOD' => 'GET',
            'URL' => static::RESOURCE_NAME_MULT . '/search.json',
            'DATA' => $options
        ]);

        $data = $results->{static::RESOURCE_NAME_MULT};

        return static::collect($data);
    }

    public static function getByEmail($email)
    {
        $customers = static::search([
            'query' => 'email:' . $email,
            'fields' => 'id',
            'limit' => 1
        ]);

        if ($customers->count()) {
            return $customers[0];
        } else {
            return false;
        }
    }

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
