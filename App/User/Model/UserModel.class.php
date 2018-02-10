<?php

namespace Model\User;

use X\Model;

class UserModel extends Model
{
    protected $table = "yoshino_user";

    public function getUserByToken($token) {
        return $this->where("token", $token)->findOne();
    }
}