<?php

namespace Model\User;

class TextureModel extends \X\Model
{
    protected $table = "yoshino_texture";

    public function addTexture($hash, $saveToDB = false, $content = "") {
        if ($this->where("hash", $hash)->findOne()) return true;
        $texture = $this->create();
        $texture->hash = $hash;
        if ($saveToDB) $texture->content = $content;
        $texture->save();
        return true;
    }
}