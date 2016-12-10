<?php

namespace Yarsky\Shopify\Model;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected static $currentToken = null;

    protected $fillable = [
        'domain', 'token'
    ];

    public static function setCurrent($token)
    {
        static::$currentToken = $token;
    }

    public static function current()
    {
        return static::$currentToken;
    }
}
