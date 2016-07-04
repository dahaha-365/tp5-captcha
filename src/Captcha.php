<?php
namespace tp5\captcha;

use Gregwar\Captcha\CaptchaBuilder;

class Captcha {
    public function index() {
        if(\think\Config::get('captcha.zh')) {
            $builder = new CaptchaZh();
        } else {
            $builder = new CaptchaBuilder();
        }
        $timeout = config('captcha.timeout', 300);
        session('captcha_phrase', $builder->getPhrase());
        session('captcha_timeout', request()->time() . $timeout);
        if(config('captcha.verify_ip', false)) {
            session('captcha_ip', request()->ip());
        }
        if(request()->isAjax()) {
            $base64 = $builder->inline();
            $verify = md5($builder->getPhrase());
            return response(['image' => $base64, 'verify' => $verify], 200, [], 'json')->cacheControl('no-store');
        } else {
            $image = $builder->get();
            return response($image, 200)->contentType('image/jpeg')->cacheControl('no-store');
        }
    }
}