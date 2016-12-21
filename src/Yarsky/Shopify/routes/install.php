<?php
use Illuminate\Http\Request;

Route::get('/install', function () {
    $verify = Sh::verifyRequest(Request::all(), true);
    if ($verify) {
        $code = Request::get('code');
        $shop = Request::get('shop');
        $accessToken = Sh::getAccessToken($code);
        $token = \Yarsky\Shopify\Model\Token::firstOrNew(['domain' => $shop]);
        $token->domain = $shop;
        $token->token = $accessToken;
        $token->save();
    } else {
        return abort(400, 'Bad request');
    }
    return redirect(config('shopify.endpoint'));
});
Route::get('/start', function () {
    return redirect(Sh::installURL([
        'permissions' => config('shopify.permissions'),
        'redirect' => config('shopify.redirect')
    ]));
});
