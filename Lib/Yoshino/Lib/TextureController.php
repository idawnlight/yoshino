<?php

namespace Yoshino\Lib;

class TextureController extends \X\Controller
{
    public function textureHash($tmp_name) {
        $skin = ImageCreateFromPng($tmp_name);
        list($width, $height) = getimagesize($tmp_name);
        $string = "";
        $string .= $width . $height;
        for ($w = 0; $w < $width; $w++) {
            for ($h = 0; $h < $height; $h++) {
                //$string .= ImageColorAt($im, $w, $h);
                $rgb = ImageColorAt($skin, $w, $h);
                $i["r"] = ($rgb >> 16) & 0xFF;
                $i["g"] = ($rgb >> 8) & 0xFF;
                $i["b"] = $rgb & 0xFF;
                $string .= $i["r"] . $i["g"] . $i["b"];
            }
        }
        return hash("sha256", $string);
    }

    public function textureContent($tmp_name) {
        ob_start();
        $skin = ImageCreateFromPng($tmp_name);
        imagesavealpha($skin, true);
        imagepng($skin);
        $data = ob_get_contents();
        ob_end_clean();
        return $data;
    }
}