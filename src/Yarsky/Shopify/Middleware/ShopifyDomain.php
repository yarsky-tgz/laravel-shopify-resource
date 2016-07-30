<?php
namespace Yarsky\Shopify\Middleware;

use Closure;
use Sh;

class ShopifyDomain
{

    public function handle($request, Closure $next, $guard = null)
    {
        if (!$request->has('shop') || !$request->has('hmac')) {
            return $next($request);
        }

        $domain = $request->input('shop');
        $setup['SHOP_DOMAIN'] = $domain;
        $token = \App\Token::where('domain', $domain)->first();

        if ($token) {
            $setup['ACCESS_TOKEN'] = $token->token;
        }

        Sh::setup($setup);

        return $next($request);
    }

}
