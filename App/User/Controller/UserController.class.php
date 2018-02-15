<?php

namespace Controller\User;

use X\Controller;

class UserController extends Controller
{
    public function user($req) {
        $token = $_COOKIE["Yoshino_Token"];
        $user = $this->getUserModel()->getUserByToken($token);

        $this->data = [
            "username" => $user->username,
            "index" => true,
            "admin" => $user->permission === "admin"
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
            "player" => true,
            "admin" => $user->permission === "admin"
        ];

        return $this->view("User/player");
    }

    public function texture($req) {
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
            "skin" => true,
            "admin" => ($user->permission === "admin")
        ];
        return $this->view("User/texture");
    }

    public function textureUpload($req) {
        $textureDir = $this->app->config['SysDir'] . $this->app->config['Path']['Texture'];
        if (!isset($_FILES["texture"])) return $this->json(["retcode" => 400, "msg" => "请选择一个文件"], "failed", 1);
        if ($_FILES["texture"]["size"] > 10240) {
            return $this->json(["retcode" => 400, "msg" => "材质不能大于 10 KB"], "failed", 1);
        } else if ($_FILES["texture"]["type"] !== "image/png") {
            return $this->json(["retcode" => 400, "msg" => "材质必须是 PNG 格式"], "failed", 1);
        }
        if (isset($req->data->post->type) && ($req->data->post->type === "skin" || $req->data->post->type === "cape") && $this->getPlayerModel()->verifyPlayer($req->data->post->player, $this->getUserModel()->getUserByToken($req->data->cookie->Yoshino_Token)->id)) {
            $tool = $this->app->boot("\\Yoshino\\Lib\\TextureController");
            $hash = $tool->textureHash($_FILES["texture"]["tmp_name"]);
            $content = $tool->textureContent($_FILES["texture"]["tmp_name"]);
            $base64 = base64_encode($content);
            $this->getTextureModel()->addTexture($hash, $this->app->config["Yoshino"]["Textures"]["SaveToDB"], $base64);
            if ($req->data->post->type === "skin") $this->getPlayerModel()->setTexture($req->data->post->player, $req->data->post->model, $hash, $this->getUserModel()->getUserByToken($req->data->cookie->Yoshino_Token)->id);
            if ($req->data->post->type === "cape") $this->getPlayerModel()->setTexture($req->data->post->player, $req->data->post->type, $hash, $this->getUserModel()->getUserByToken($req->data->cookie->Yoshino_Token)->id);
            file_put_contents($textureDir . $hash . ".png", $content);
            return $this->json(["retcode" => 200, "msg" => "上传成功", "hash" => $hash], "succeed", 1);
        } else {
            return $this->json(["retcode" => 400, "msg" => "非法请求"], "failed", 1);
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