<?php

namespace Controller\User;

use X\Controller;

class UserController extends Controller
{
    public function user($req) {
        $this->checkLogin($req);

        $token = $_COOKIE["Yoshino_Token"];
        $user = $this->getUserModel()->getUserByToken($token);

        $this->data = [
            "username" => $user->username,
            "index" => true
        ];

        return $this->view("User/index");
    }

    public function player($req) {
        $this->checkLogin($req);

        $token = $_COOKIE["Yoshino_Token"];
        $user = $this->getUserModel()->getUserByToken($token);
        $players = $this->getPlayerModel()->getPlayersById($user->id);

        $playersList = [];
        foreach ($players as $player) {
            $playersList[] = $player->player;
        }

        $this->data = [
            "username" => $user->username,
            "players" => $playersList,
            "collapse-1" => true,
            "player" => true
        ];

        return $this->view("User/player");
    }

    public function skin($req) {
        $this->checkLogin($req);

        $token = $_COOKIE["Yoshino_Token"];
        $user = $this->getUserModel()->getUserByToken($token);
        $players = $this->getPlayerModel()->getPlayersById($user->id);

        $playersList = [];
        foreach ($players as $player) {
            $playersList[] = $player->player;
        }

        $this->data = [
            "username" => $user->username,
            "players" => $playersList,
            "collapse-1" => true,
            "skin" => true
        ];
        return $this->view("User/skin");
    }

    public function managePlayer($req) {
        if ($this->checkLogin(true)) {
            if (isset($req->data->post->player) && $req->data->post->player !== "") {
                if ($this->getPlayerModel()->addPlayer($req->data->post->player, $this->getUserModel()->getUserByToken($_COOKIE["Yoshino_Token"])->id)) {
                    return $this->json(array("retcode" => 200, "msg" => "成功添加角色"), "succeed", 1);
                } else {
                    return $this->json(array("retcode" => 400, "msg" => "这个角色名已经被占用啦"), "failed", 1);
                }
            } else if (isset($req->data->post->removePlayer) && $req->data->post->removePlayer !== "") {
                if ($this->getPlayerModel()->removePlayer($req->data->post->removePlayer)) {
                    return $this->json(array("retcode" => 200, "msg" => "成功删除角色"), "succeed", 1);
                } else {
                    return $this->json(array("retcode" => 400, "msg" => "删除角色失败"), "failed", 1);
                }
            } else {
                return $this->json(array("retcode" => 400, "msg" => "非法请求"), "failed", 1);
            }
        } else {
            return $this->json(array("retcode" => 400, "msg" => "非法请求"), "failed", 1);
        }
    }

    private function getUserModel() {
        return $this->model("User/UserModel");
    }

    private function getPlayerModel() {
        return $this->model("User/PlayerModel");
    }

    private function checkLogin($return = false) {
        $db = $this->model("Auth/AuthModel");

        if (!isset($_COOKIE["Yoshino_Token"])) {
            $_COOKIE["Yoshino_Token"] = $this->genToken();
            if ($return) return false;
            header("location: /");
            exit();
        } else {
            if ($db->isTokenValid($_COOKIE["Yoshino_Token"])) {
                setcookie("Yoshino_Token", $_COOKIE["Yoshino_Token"], time()+8640000, "/");
                if ($return) return true;
            } else {
                $_COOKIE["Yoshino_Token"] = $this->genToken();
                header("location: /");
                exit();
            }
        }
    }

    public function genToken() {
        $token = $this->randString(128);
        setcookie("Yoshino_Token", $token, time()+8640000, "/");
        return $token;
    }

    public function randString($length, $specialChars = false) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($specialChars) {
            $chars .= '!@#$%^&*()';
        }

        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[rand(0, $max)];
        }
        return $result;
    }
}