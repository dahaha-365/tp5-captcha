<?php
namespace tp5\captcha;

use Gregwar\Captcha\CaptchaBuilder;

class CaptchaZh extends CaptchaBuilder {
    protected function writePhrase($image, $phrase, $font, $width, $height)
    {
        $length = mb_strlen($phrase);
        if ($length === 0) {
            return imagecolorallocate($image, 0, 0, 0);
        }

        // Gets the text size and start position
        $size = ($width / $length - $this->rand(3, 10)) * 0.8;
        $box = imagettfbbox($size, 0, $font, $phrase);
        $textWidth = $box[2] - $box[0];
        $textHeight = $box[1] - $box[7];
        $x = ($width - $textWidth) / 2 * 1.2;
        $y = ($height - $textHeight) / 2 + ($size * 1.1);

        if (!count($this->textColor)) {
            $textColor = array($this->rand(0, 150), $this->rand(0, 150), $this->rand(0, 150));
        } else {
            $textColor = $this->textColor;
        }
        $col = imagecolorallocate($image, $textColor[0], $textColor[1], $textColor[2]);

        // Write the letters one by one, with random angle
        for ($i=0; $i<$length; $i++) {
            $box = imagettfbbox($size, 0, $font, mb_substr($phrase, $i, 1));
            $w = $box[2] - $box[0];
            $angle = $this->rand(-$this->maxAngle, $this->maxAngle);
            $offset = $this->rand(-$this->maxOffset, $this->maxOffset);
            imagettftext($image, $size, $angle, $x, $y + $offset, $col, $font, mb_substr($phrase, $i, 1));
            $x += $w;
        }

        return $col;
    }
}