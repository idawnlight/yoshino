<?php

namespace Controller\Auth;

use X\Controller;

class AuthController extends Controller
{
    public function login($req) {
        $this->data = [
            "collapse-1" => true,
            "login" => true
        ];

        return $this->view("Auth/login");
    }

    public function loginCheck($req) {
        if (isset($req->data->post->identification) && isset($req->data->post->password)) {
            if ($req->data->post->identification == "" || $req->data->post->password == "")
                return $this->json(array("retcode" => 400, "msg" => "所有项目均为必填项"), "failed", 1);

            $token = $_COOKIE["Yoshino_Token"];
            $encrypt = $this->app->boot("\\Yoshino\\Lib\\EncryptController");

            //$result = $this->getAuthModel()->loginCheck($req->data->post->identification,
            //    hash("sha256", $req->data->post->password . "69249f9626a4ce1488b6a6c8fb7919b5"),
            //    $token);
            $password = $this->getAuthModel()->getPassword($req->data->post->identification);
            $result = ($password) ? $encrypt->verify($req->data->post->password, $password) : false;

            if ($result) {
                $this->model("Auth/AuthModel")->setToken($req->data->post->identification, $token);
                return $this->json(array("retcode" => 200, "msg" => "登录成功"), "succeed", 1);
            } else {
                return $this->json(array("retcode" => 400, "msg" => "用户名或密码不正确"), "failed", 1);
            }
        } else {
            return $this->json(array("retcode" => 400, "msg" => "非法请求"), "failed", 1);
        }
    }

    public function reg($req) {
        $this->data = [
            "collapse-1" => true,
            "reg" => true
        ];

        return $this->view("Auth/reg");
    }

    public function regCheck($req) {
        if (isset($req->data->post->username) && isset($req->data->post->password) && isset($req->data->post->repeatpwd) && isset($req->data->post->email)) {
            $req->data->post->username = $this->testInput($req->data->post->username);
            $req->data->post->email = $this->testInput($req->data->post->email);
            if ($req->data->post->username == "" || $req->data->post->password == "" || $req->data->post->email == "")
                return $this->json(array("retcode" => 400, "msg" => "所有项目均为必填项"), "failed", 1);
            if (strlen($req->data->post->username) > 20)
                return $this->json(array("retcode" => 400, "msg" => "用户名最长为 20 个字符"), "failed", 1);
            if (strlen($req->data->post->username) < 4)
                return $this->json(array("retcode" => 400, "msg" => "用户名最短为 4 个字符"), "failed", 1);
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $req->data->post->email))
                return $this->json(array("retcode" => 400, "msg" => "无效的邮箱格式"), "failed", 1);
            if (strlen($req->data->post->password) > 30)
                return $this->json(array("retcode" => 400, "msg" => "密码最长为 30 个字符"), "failed", 1);
            if (strlen($req->data->post->password) < 6)
                return $this->json(array("retcode" => 400, "msg" => "密码最短为 6 个字符"), "failed", 1);
            if ($req->data->post->password !== $req->data->post->repeatpwd)
                return $this->json(array("retcode" => 400, "msg" => "两次输入的密码不一致"), "failed", 1);

            $auth = $this->model("Auth/AuthModel");
            $token = $_COOKIE["Yoshino_Token"];
            $encrypt = $this->app->boot("\\Yoshino\\Lib\\EncryptController");
            $exist = $auth->isUserExist($req->data->post->username, $req->data->post->email, $token);
            if (!$exist) {
                $auth->addUser($req->data->post->username, $encrypt->encrypt($req->data->post->password), $req->data->post->email, $token);
                return $this->json(array("retcode" => 200, "msg" => "注册成功"), "succeed", 1);
            } else if ($exist === "token") {
                return $this->json(array("retcode" => 400, "msg" => "疑似注册小号行为，已被拦截。<br>如果你认为存在错误，请联系管理员。"), "failed", 1);
            } else if ($exist  === "username") {
                return $this->json(array("retcode" => 400, "msg" => "相同用户名已存在"), "failed", 1);
            } else if ($exist === "email") {
                return $this->json(array("retcode" => 400, "msg" => "相同邮箱已存在"), "failed", 1);
            }
        } else {
            return $this->json(array("retcode" => 400, "msg" => "非法请求"), "failed", 1);
        }
    }

    public function logout() {
        setcookie("Yoshino_Token", null, -1, "/");
        return $this->response("", ["location" => "/"], 302);
    }

    private function testInput($text) {
        return htmlspecialchars(stripslashes(trim($text)));
    }

    private function getAuthModel() {
        return $this->model("Auth/AuthModel");
    }
}