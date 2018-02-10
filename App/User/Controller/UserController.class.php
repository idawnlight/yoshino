<?php

namespace Controller\User;

use X\Controller;

define("TextureDir", SysDir . "Var/Textures/");

class UserController extends Controller
{
    public function user($req) {
        $token = $_COOKIE["Yoshino_Token"];
        $user = $this->getUserModel()->getUserByToken($token);

        $this->data = [
            "username" => $user->username,
            "index" => true
        ];

        return $this->view("User/index");
    }

    public function player($req) {
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

    public function skinUpload($req) {
        if (!isset($_FILES["skin"])) return $this->json(["retcode" => 400, "msg" => "请选择一个文件"], "failed", 1);
        if ($_FILES["skin"]["size"] > 10240) {
            return $this->json(["retcode" => 400, "msg" => "皮肤不能大于 10 KB"], "failed", 1);
        } else if ($_FILES["skin"]["type"] !== "image/png") {
            return $this->json(["retcode" => 400, "msg" => "皮肤必须是 PNG 格式"], "failed", 1);
        }
        if ($this->getPlayerModel()->verifyPlayer($req->data->post->player, $this->getUserModel()->getUserByToken($req->data->cookie->Yoshino_Token)->id)) {
            $tool = $this->app->boot("\\Yoshino\\Lib\\SkinController");
            $hash = $tool->skinHash($_FILES["skin"]["tmp_name"]);
            $content = $tool->skinContent($_FILES["skin"]["tmp_name"]);
            $base64 = base64_encode($content);
            $this->getTextureModel()->addTexture($hash, true, $base64);
            $this->getPlayerModel()->setTexture($req->data->post->player, $req->data->post->type, $hash, $this->getUserModel()->getUserByToken($req->data->cookie->Yoshino_Token)->id);
            file_put_contents(TextureDir . $hash . ".png", $content);
            return $this->json(["retcode" => 200, "msg" => "上传成功", "hash" => $hash], "succeed", 1);
        } else {
            return $this->json(["retcode" => 400, "msg" => "鉴权失败"], "failed", 1);
        }

    }

    public function managePlayer($req) {
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
    }

    private function getUserModel() {
        return $this->model("User/UserModel");
    }

    private function getPlayerModel() {
        return $this->model("User/PlayerModel");
    }

    private function getTextureModel() {
        return $this->model("User/TextureModel");
    }
}