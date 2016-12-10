<?php
namespace Yarsky\Shopify\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Yarsky\Shopify\Model\Token;

class TokenScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('token_id', Token::current()->id);
    }
}
