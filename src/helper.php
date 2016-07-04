<?php
\think\Route::get('captcha/[:phrase]', "\\tp5\\captcha\\Captcha@index");
\think\Validate::extend('captcha', function ($phrase) {
    return captcha_check($phrase);
});
\think\Validate::setTypeMsg('captcha', '验证码错误!');

if(!function_exists('captcha_check')) {
    function captcha_check($phrase = null) {
        if(config('captcha.verify_ip')) {
            if(request()->ip() !== session('captcha_ip')) {
                return false;
            }
        }
        if(session('captcha_timeout') < request()->time()) {
            return false;
        }
        if($phrase === null) {
            $phrase = request()->param('phrase', '', 'strval');
        }
        if($phrase !== session('captcha_phrase')) {
            return false;
        } else {
            return true;
        }
    }
}