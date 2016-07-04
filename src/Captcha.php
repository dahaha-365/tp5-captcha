<?php
namespace tp5\captcha;

use Gregwar\Captcha\CaptchaBuilder;
load_trait('controller/Jump');

class Captcha {
    use \traits\controller\Jump;

    public function index($phrase = null) {
        if($phrase !== null) {
            $valid = captcha_check($phrase);
            if(request()->isAjax()) {
                return response(['verify' => $valid], 200, [], 'json')->cacheControl('no-store');
            } else {
                $this->error('验证码错误');
            }
        }
        if(\think\Config::get('captcha.zh')) {
            $builder = new CaptchaZh();
        } else {
            $builder = new CaptchaBuilder();
        }
        $builder->build();
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
            $builder->build();
            $image = $builder->get();
            return response($image, 200)->contentType('image/jpeg')->cacheControl('no-store');
        }
    }
}