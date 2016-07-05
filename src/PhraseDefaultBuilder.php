<?php
namespace tp5\captcha;
use Gregwar\Captcha\PhraseBuilder;

/**
 * Generates random phrase
 *
 * @author Gregwar <g.passault@gmail.com>
 */
class PhraseDefaultBuilder extends PhraseBuilder
{
    /**
     * Generates  random phrase of given length with given charset
     */
    public function build($length = 5, $charset = 'ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz123456789')
    {
        $phrase = '';
        $chars = str_split($charset);

        for ($i = 0; $i < $length; $i++) {
            $phrase .= $chars[array_rand($chars)];
        }

        return $phrase;
    }
}
