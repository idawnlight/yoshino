<?php
/**
 * Created by PhpStorm.
 * User: m1255
 * Date: 2018/2/13
 * Time: 16:35
 */

namespace Model\Dashboard;

class TextureModel extends \X\Model
{
    protected $table = "yoshino_texture";

    public function getTextureCount() {
        return $this->count();
    }
}