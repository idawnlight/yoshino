<?php

namespace Controller\Auth;

use X\Controller;

class AuthController extends Controller
{
    public function login($req) {
        self::checkLogin();

        return $this->view("Auth/login");
    }

    public function loginCheck($req) {
        if (isset($req->data->post->identification) && isset($req->data->post->password)) {
            if ($req->data->post->identification == "" || $req->data->post->password == "")
                return $this->json(array("retcode" => 400, "msg" => "所有项目均为必填项"), "failed", 1);

            $token = $_COOKIE["Yoshino_Token"];

            $result = $this->getAuthModel()->loginCheck(self::testInput($req->data->post->identification),
                hash("sha256", $req->data->post->password . "69249f9626a4ce1488b6a6c8fb7919b5"),
                $token);

            if ($result) {
                $this->model("Auth/AuthModel")->setToken(self::testInput($req->data->post->identification), $token);
                return $this->json(array("retcode" => 200, "msg" => "登录成功"), "succeed", 1);
            } else {
                return $this->json(array("retcode" => 400, "msg" => "用户名或密码不正确"), "failed", 1);
            }
        } else {
            return $this->json(array("retcode" => 400, "msg" => "非法请求"), "failed", 1);
        }
    }

    public function reg($req) {
        self::checkLogin();

        return $this->view("Auth/reg");
    }

    public function regCheck($req) {
        if (isset($req->data->post->username) && isset($req->data->post->password) && isset($req->data->post->repeatpwd) && isset($req->data->post->email)) {
            if ($req->data->post->username == "" || $req->data->post->password == "" || $req->data->post->email == "")
                return $this->json(array("retcode" => 400, "msg" => "所有项目均为必填项"), "failed", 1);
            if (strlen(self::testInput($req->data->post->username)) > 20)
                return $this->json(array("retcode" => 400, "msg" => "用户名最长为 20 个字符"), "failed", 1);
            if (strlen(self::testInput($req->data->post->username)) < 4)
                return $this->json(array("retcode" => 400, "msg" => "用户名最短为 4 个字符"), "failed", 1);
            if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", self::testInput($req->data->post->email)))
                return $this->json(array("retcode" => 400, "msg" => "无效的邮箱格式"), "failed", 1);
            if (strlen(self::testInput($req->data->post->password)) > 30)
                return $this->json(array("retcode" => 400, "msg" => "密码最长为 30 个字符"), "failed", 1);
            if (strlen(self::testInput($req->data->post->password)) < 6)
                return $this->json(array("retcode" => 400, "msg" => "密码最短为 6 个字符"), "failed", 1);
            if ($req->data->post->password !== $req->data->post->repeatpwd)
                return $this->json(array("retcode" => 400, "msg" => "两次输入的密码不一致"), "failed", 1);

            $auth = $this->model("Auth/AuthModel");
            $token = $_COOKIE["Yoshino_Token"];
            $exist = $auth->isUserExist(self::testInput($req->data->post->username), self::testInput($req->data->post->email), $token);
            if (!$exist) {
                $auth->addUser(self::testInput($req->data->post->username), hash("sha256", $req->data->post->password . "69249f9626a4ce1488b6a6c8fb7919b5"), self::testInput($req->data->post->email), $token);
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
        setcookie("Yoshino_Token", $_COOKIE["Yoshino_Token"], -1, "/");
        $this->genToken();
        header("location: /");
        exit();
    }

    private function checkLogin() {
        $db = $this->model("Auth/AuthModel");

        if (!isset($_COOKIE["Yoshino_Token"])) {
            $_COOKIE["Yoshino_Token"] = self::genToken();
        } else {
            if ($db->isTokenValid($_COOKIE["Yoshino_Token"])) {
                setcookie("Yoshino_Token", $_COOKIE["Yoshino_Token"], time()+8640000, "/");
                header("location: /user");
                exit();
            }
        }
    }

    public function genToken() {
        $token = self::randString(128);
        setcookie("Yoshino_Token", $token, time()+8640000, "/");
        return $token;
    }

    private function testInput($text) {
        return htmlspecialchars(stripslashes(trim($text)));
    }

    private function getAuthModel() {
        return $this->model("Auth/AuthModel");
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