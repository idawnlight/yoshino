<?php
/**
 * Created by PhpStorm.
 * User: m1255
 * Date: 2018/2/13
 * Time: 16:07
 */

namespace Model\Dashboard;

class UserModel extends \X\Model
{
    protected $table = "yoshino_user";

    public function getUserCount() {
        return $this->count();
    }
}