<?php
namespace tp5\captcha;

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
        $builder = captcha_init();
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