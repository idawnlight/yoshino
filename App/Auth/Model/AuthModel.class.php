<?php

namespace Model\Auth;

use X\Model;

class AuthModel extends Model
{
    protected $table = "yoshino_user";

    public function addUser($username, $password, $email, $token) {
        $i = $this->create();
        //$i->id       = 1234;
        $i->username = $username;
        $i->password = $password;
        $i->email    = $email;
        $i->token    = $token;
        $i->save();
    }

    public function loginCheck($identification, $password) {
        $result = $this->where_raw('(`username` = ? OR `email` = ?)', array($identification, $identification))->where("password", $password)->findOne();
        if ($result == "") {
            return false;
        } else {
            return true;
        }
    }

    public function setToken($identification, $token) {
        $result = $this->where_raw('(`username` = ? OR `email` = ?)', array($identification, $identification))->findOne();
        $result->token = $token;
        $result->save();

        return true;
    }

    public function isUserExist($username, $email, $token) {
        $result = $this->where_raw('(`token` = ? OR `username` = ? OR `email` = ?)', array($token, $username, $email))->findOne();

        if ($result == "") {
            return false;
        } else if ($result->token == $token) {
            return "token";
        } else if ($result->username == $username) {
            return "username";
        } else if ($result->email == $email) {
            return "email";
        }
    }

    public function isTokenValid($token = "") {
        return ($token === "") ? false : $this->where("token", $token)->findOne();
    }

}