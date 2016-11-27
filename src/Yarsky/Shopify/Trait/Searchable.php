<?php

namespace Yarsky\Shopify\Trait;

trait Searchable
{
    public static function search($options = array())
    {
        $results =  self::call([
            'METHOD' => 'GET',
            'URL' => static::RESOURCE_NAME_MULT . '/search.json',
            'DATA' => $options
        ]);

        $data = $results->{static::RESOURCE_NAME_MULT};

        return static::collect($data);
    }
}
