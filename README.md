# tp5-captcha
captcha package for ThinkPHP 5, base on [`gregwar/captcha`][2]

基于[`gregwar/captcha`][2]的ThinkPHP 5验证码扩展

[![Latest Stable Version](https://poser.pugx.org/tp5/captcha/v/stable)](https://packagist.org/packages/tp5/captcha) [![Latest Unstable Version](https://poser.pugx.org/tp5/captcha/v/unstable)](https://packagist.org/packages/tp5/captcha) [![Total Downloads](https://poser.pugx.org/tp5/captcha/downloads)](https://packagist.org/packages/tp5/captcha) [![Monthly Downloads](https://poser.pugx.org/tp5/captcha/d/monthly)](https://packagist.org/packages/tp5/captcha) [![License](https://poser.pugx.org/tp5/captcha/license)](https://packagist.org/packages/tp5/captcha)
******

##安装
```bash
composer require tp5/captcha
```

##特色
* 更适合API验证码开发
* 使用文泉驿开源中文字体,没有版权问题
* 支持[`gregwar/captcha`][2]的所有API
* 支持Validation验证起验证规则
```php
$this->validate($data,[
    'captcha|验证码'=>'required|captcha'
]);
```

* 使用助手函数进行验证
```php
captcha_check($phrase);
```

##配置
```php
[
    'captcha' => [
        'verify_ip' => false, // 是否验证ip匹配
        'zh' => false, // 是否使用中文验证码
        'timeout' => 300, // 验证码的过期时间,单位秒
        'width' => 150, // 验证码图片宽度
        'height' => 40, // 验证码图片宽度高度
        'prefix' => 'captcha', // 验证码session前缀
        'detect_case' => false, // 是否区分大小写
    ]
]
```

##使用
正常访问`http://yourdomain/captcha`显示验证码图片,如果用ajax请求会返回json格式的验证码数据:
```json
{
    "image": "data:image\/jpeg;base64,\/9j\/4AAQSkZJRgABAQAAAQABAAD\/\/gA7Q1JFQVRPUjogZ2QtanBlZyB2MS4wICh1c2luZyBJSkcgSlBFRyB2NjIpLCBxdWFsaXR5ID0gOTAK\/9sAQwADAgIDAgIDAwMDBAMDBAUIBQUEBAUKBwcGCAwKDAwLCgsLDQ4SEA0OEQ4LCxAWEBETFBUVFQwPFxgWFBgSFBUU\/9sAQwEDBAQFBAUJBQUJFA0LDRQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU\/8AAEQgAKACWAwEiAAIRAQMRAf\/EAB8AAAEFAQEBAQEBAAAAAAAAAAABAgMEBQYHCAkKC\/\/EALUQAAIBAwMCBAMFBQQEAAABfQECAwAEEQUSITFBBhNRYQcicRQygZGhCCNCscEVUtHwJDNicoIJChYXGBkaJSYnKCkqNDU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6g4SFhoeIiYqSk5SVlpeYmZqio6Slpqeoqaqys7S1tre4ubrCw8TFxsfIycrS09TV1tfY2drh4uPk5ebn6Onq8fLz9PX29\/j5+v\/EAB8BAAMBAQEBAQEBAQEAAAAAAAABAgMEBQYHCAkKC\/\/EALURAAIBAgQEAwQHBQQEAAECdwABAgMRBAUhMQYSQVEHYXETIjKBCBRCkaGxwQkjM1LwFWJy0QoWJDThJfEXGBkaJicoKSo1Njc4OTpDREVGR0hJSlNUVVZXWFlaY2RlZmdoaWpzdHV2d3h5eoKDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uLj5OXm5+jp6vLz9PX29\/j5+v\/aAAwDAQACEQMRAD8A+u6KKKCyC4vra0GZ7iKEesjhf51HbavY3rFbe9t52HURSqxH5GvJPGGneAdA1+WPX5tT1fU5z5wtmkkl2gk4AC4AHFcl4um8AzeHr46doOp6ZfpEWt53t3RA46fNk\/rXz1bM5UXK\/Jp05tf\/AEmyZooXPpIHIyORS14D4Sj0W80OyltviNqGl3zxKZ7eW5D7HxyAGwQPxNdt4HtdOt9clmHjq98R3MMDO1vLc7okXIBbaOO4\/OumhmDruKUFr\/ei\/wDg\/gDgejswUZJAHvS15R441yPxD4vsLSF8aboYOoX7yEwjdj5EyR36\/lVTxR4+8Qax4Q8Panpbf2HJqOqR20cv3yUbcASrKQVPB\/DpVzzCnB1Lq\/L23drX+5u2+9yvZS66HsVY2v8AjHRfC6g6pqUFmxGRGzZcj2UZJ\/KuG8S698QfA2iXeo3L6Fq9laKGeYxyRTNkgfdB29\/arnj7xlofhfRG1iZdPfxLJZobeF9pmO7oQOu0Ek\/gaVXHKMJ\/YcVd8y6a9nrt0ZCibvhz4k6F4ne7FpctELZxGzXS+SGJGQBuwT0q5pHi6z1fXtT0hFeO7sQjndjbIjDh1IPIr5sg8YQL4NO\/wvFrNvFOZLq\/v5irm8kBOdqMDt4wPoemawrOXVvDoW5s3aK+kfyVuNO1NWdt3KIFUnjPUfQHHf53+36keRtc3V2T27bfinbRmvs0fZtYPibxzoXg7yv7Y1KKyaUEojBmZgO4VQTXiWpX\/wAWvCnhprm\/vltVNwsC+Y0U08pfgbSAwAGO5B5pnhjwhqGieMdK06+0PT5pNSYzTjUyt7cpGvVi20KvPHAya9Keb1JNQpUXGTt8Sel3ZaLv5tfMjkXVncH9pDwwVYx2eqyBD+8C265Rf75+bpnHvzSn9ojRJN8dvpOsT3anP2dbcbiv94c9OnXHWoPCuueO\/Eceo3un3GkzW9pfTWgtrmNkchMdGXjuOvpXUeCfGd9r2tanpGq6THpuoaaiMwilEiEPnGD+FKjiMTWcV7W3Ntenv8+Zrp1BpLp+Jzf9v+O\/iIfK0nTh4W0K4+U6ldjN2mOpVN4IyRjp361ueFPhFp2g3sWpahe3mv6zE++O+vZnJQ4xwu4j165Nd5RXqwwMOZVKzc5Lq9l6LZfn5kOXRaBRRRXpEhRRRQB454mtZv8AhfVgq3LWf2vS2iWaHG5cFj3zSvo3iH7Fq1nc3y+ItEltZfL1JLja8TAH5WQHa3p0z71Y8fRKnxn8Fu4DRzxzxMD0YbDx\/wCPVrx\/DP8A4RnVru90W9a00q4hk+1aa2XRjtOCvPFfKqlOVWqop2U3ezto4xe2zXfr2OlTcUrO2h4\/p+uaPYeFtDnuLfSNXjS3P2uyeVYryMiRgGVzyeB9zJ6g46GpbP4geGfC\/jt9b0bTZLqxbS1RbRo9jLOZR1JBAIAHzDPXHWtrwd8OoPE3w20\/ULaeGx1WwmmVXnRWhlORxIrDBzwM9eB6VvWN3fz\/ABg8Jy6obZtSk0uaO4W0bci43kV49OnieWk7qN+Sz5U99N73vrs7p9DR1G9LnjOtJ\/wlXjC+mvmXQFuT9okSVzcMGblQABndggYwMd8V12veAdQtfDvha9bxRqckNxfw2sUF5E6fZWYn94gZ\/lxtzjA+td5BeXjeINQHgvwWkU8k8hm1rUtyoz7juK56856H8KxfifrFxLp+gaD4kvbKfUk1SCW5WLfGvlNu744ABwSCTz7VH1CnTpValV3b66xV77Xur\/KNt9SLttJCeP8A4eeKdH8Faxf3\/je51K1RVL2bRHZKu5QOr4XscAduvNVvH\/wfh8PeB\/7Ss7uGeL7IlxcXF5+9unkbbtjUkAKoyTxz2yat\/EHwNb6b4F1a907xHcTWsaKTaLeGeKQF1GME5UD0ya67xdpupa34SttI0ix\/tOXULVY5b+e5xHbYC\/wgY6egHTua9CrgKMpVYzi7qCtZubbbls97d\/8AhybvTU0bbUZvDvgDTbbw14Rhu1mhjLKFRVdmQfvHLEs31PNeeX2nR+CL\/wD4SXxObK78TOMafo1igEaSHO0kDrg9+fqa9V1Tw1rEvhfTdK0vWP7Mngijhmuki3MyqgU7c9DxWFD8CvD7WNyl7Ld6hqFwOdRnlJmRuzL2BBruxGCqTaVCnblStdrlTt2WrfrojKPLE5\/xZY6xYfCXTm166e51OTUIJ5Q\/\/LLL5CfhWzFcT6J8a5jqcSyJq1sItPnU\/wCrVOWTHqTk1heNLbxHp3w1vbLxA0d19jvoFtr5W+e4jDDDMOx7f49a6hvD+s6r4zg1\/wAQy2On6VpDS\/ZI4pCWfPAkcnhRjtnvWUYydWKgpXXs3r5cyfM\/S+vfYvoct8NvD+uX0fiO50jxA+mmLWrmP7JJAskLEbTuPfPOPwrW+HMep2\/xR8VRavLBNffZrcvJbKVRh82CAelYPw88J2fii+8VXNrrt5p18urziKSwugA0ZwQ23oep5rc8B6fe6P8AFvxBaX+oNqc5sYGFw6BWZecZx396ywsWvq8uV25nrzXW0unR+iB9T1iiiivsTEKKKKACiiigDMv\/AA5p2p6pZajdWqTXllu+zyN1jzjJH5VpEBgQQCDwQaKKlRjFtpb7gZs3hrTJ9JudMNlFHY3G7zIYhsU56njGPwrF0L4WeGfDl21xY6cEldSrmWRpdw9DvJ\/IUUVn7GlzqpyrmWzsrr07DTa2OrjjSJAiKEQcBVGAKp6joenawhW+sbe7BGP30Ssf1FFFayipK0lcRyd38E\/CF2Wxppt1blkhmdVP4ZxXUaB4esPDGmpY6dD5FspLbSxYknqcmiiuenhaFGXPTgk\/JJDbb3NKiiiukRzfxA8LS+MvDU2lwzpbvI6N5jgkDDZ6Ctu90631Oxks7uJbi2lXZJG44YehoorL2UOeU7atJP0V\/wDNhc5G++DHhC9QBdIjs2HIktGaJgfXINZ2m\/CK40LxHHq2n+JtQ8zCxyreYnLxA\/c3Nzj+VFFcksBhXJSUEmu2n5WK5mekUUUV6BIUUUUAf\/\/Z",
    "verify": "6a67810e2b84a8e139fb6efce2f5a4fe"
}
```
`image`字段为验证码图片的base64编码字符串,verify字段为验证码md5结果,在前端可以通过[js-md5][1]进行校验，提升用户体验,同时这种数据结构也更适合API开发。

可以使用助手函数
```php
echo captcha_img($class = '')
```
或者在模板中使用
```
{:captcha_img('class')}
```
输出验证码

访问`http://yourdomain/captcha/xxxx`可以检验验证码。

  [1]: https://github.com/blueimp/JavaScript-MD5
  [2]: https://github.com/gregwar/captcha