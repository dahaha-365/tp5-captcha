<?php
\think\Route::get('captcha/[:phrase]', "\\tp5\\captcha\\Captcha@index");
\think\Validate::extend('captcha', function ($phrase) {
    return captcha_check($phrase);
});
\think\Validate::setTypeMsg('captcha', '验证码错误!');

if(!function_exists('captcha_check')) {
    /**
     * 检查验证码是否正确
     * @param null $phrase 输入的验证码
     * @param array $config captcha_init()时传入的配置
     * @return bool
     */
    function captcha_check($phrase = null, $config = []) {
        $config = captcha_config($config);
        if($config['verify_ip']) {
            if(md5(request()->ip()) !== session('captcha_ip')) {
                return false;
            }
        }
        if(session('captcha_timeout') < request()->time()) {
            return false;
        }
        if($phrase === null) {
            $phrase = request()->param('phrase', '', 'strval');
        }
        if(md5($phrase) !== session('captcha_phrase')) {
            return false;
        } else {
            return true;
        }
    }
}

if(!function_exists('captcha_init')) {
    /**
     * 初始化验证码
     * @param array $config 验证码配置
     * @return \Gregwar\Captcha\CaptchaBuilder|\tp5\captcha\CaptchaZh
     */
    function captcha_init($config = []) {
        $config = captcha_config($config);
        if($config['zh']) {
            $builder = new \tp5\captcha\CaptchaZh();
        } else {
            $builder = new \Gregwar\Captcha\CaptchaBuilder();
        }
        $builder->build();
        session('captcha_phrase', md5($builder->getPhrase()));
        session('captcha_timeout', request()->time() + $config['timeout']);
        if($config['verify_ip']) {
            session('captcha_ip', md5(request()->ip()));
        }
        return $builder;
    }
}

if(!function_exists('captcha_config')) {
    /**
     * 获取验证码配置
     * @param array $config 验证码配置
     * @return array
     */
    function captcha_config($config = []) {
        $conf = config('captcha', null, [
            'verify_ip' => false, // 是否验证ip匹配
            'zh' => false, // 是否使用中文验证码
            'timeout' => 300, // 验证码的过期时间,单位秒
        ]);
        return array_merge($conf, $config);
    }
}