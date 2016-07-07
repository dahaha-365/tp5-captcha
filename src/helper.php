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
        session([
            'prefix' => $config['prefix'],
            'auto_start' => true,
        ]);
        if($config['verify_ip']) {
            if(md5(request()->ip()) !== session('captcha_ip')) {
                return false;
            }
        }
        if(session('captcha_timeout') < request()->time()) {
            return false;
        }
        if($phrase === null) {
            $phrase = request()->param('captcha', '', 'strval');
        }
        if(!$config['detect_case']) {
            $phrase = strtolower($phrase);
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
        static $builder = null;
        $font = null;
        if(null === $builder) {
            if($config['zh']) {
                $builder = new \tp5\captcha\CaptchaZh(null, new \tp5\captcha\PhraseZhBuilder());
                $font = __DIR__ . '/fonts/wqy-microhei.ttf';
            } else {
                $builder = new \Gregwar\Captcha\CaptchaBuilder(null, new \tp5\captcha\PhraseDefaultBuilder());
            }
        }
        $builder->build($config['width'], $config['height'], $font);
        session([
            'prefix' => $config['prefix'],
            'auto_start' => true,
        ]);
        $phrase = $builder->getPhrase();
        if(!$config['detect_case']) {
            $phrase = strtolower($phrase);
        }
        session('captcha_phrase', md5($phrase));
        session('captcha_timeout', request()->time() + $config['timeout']);
        if($config['verify_ip']) {
            session('captcha_ip', md5(request()->ip()));
        }
        return $builder;
    }
}

if(!function_exists('captcha_img')) {
    /**
     * 输出验证码图片
     * @param string $class 验证码的html类名
     * @return string
     */
    function captcha_img($class = '') {
        return sprintf('<img class="%1$s" src="%2$s" onclick="this.src=\'%2$s?ver=\'+new Date().getTime()" title="点击刷新验证码" />', $class, \think\Url::build('/captcha'));
    }
}

if(!function_exists('captcha_config')) {
    /**
     * 获取验证码配置
     * @param array $config 验证码配置
     * @return array
     */
    function captcha_config($config = []) {
        $default = [
            'verify_ip' => false, // 是否验证ip匹配
            'zh' => false, // 是否使用中文验证码
            'timeout' => 300, // 验证码的过期时间,单位秒
            'width' => 150, // 验证码图片宽度
            'height' => 40, // 验证码图片宽度高度
            'prefix' => 'captcha', // 验证码session前缀
            'detect_case' => false, // 是否区分大小写
        ];
        $conf = (array)config('captcha');
        return array_merge($default, $conf, $config);
    }
}