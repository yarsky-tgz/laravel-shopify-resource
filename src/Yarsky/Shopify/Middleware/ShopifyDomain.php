<?php
namespace Yarsky\Shopify\Middleware;

use Closure;
use Sh;

class ShopifyDomain
{

    public function handle($request, Closure $next, $guard = null)
    {
        $setCookie = false;

        if (!$request->has('shop') && !$request->hasCookie('shopify_domain')) {
            return $next($request);
        }

        if (!$request->has('shop')) {
            $domain = $request->cookie('shopify_domain');
        } else {
            $domain = $request->input('shop');
            $setCookie = true;
        }

        $setup['SHOP_DOMAIN'] = $domain;
        $token = \App\Token::where('domain', $domain)->first();

        if ($token) {
            $setup['ACCESS_TOKEN'] = $token->token;
        }

        \DebugBar::info($setup);
        Sh::setup($setup);

        if ($setCookie) {
            $response = $next($request);
            $response->withCookie(cookie()->forever('shopify_domain', $domain));
            return $response;
        } else {
            return $next($request);
        }

    }

}
