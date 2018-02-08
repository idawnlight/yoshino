<?php
    /**
     * Yoshino
     * @description A lite and fast Minecraft Skin Server
     * @author Dawn <i@emiria.moe>
     * @version 1.0.0
     */
    
    namespace Controller\Home;
    
    use X\Controller;

    class IndexController extends Controller
    {

        public function index($req){
            $this->checkLogin();

            $this->data = [
                "index" => true
            ];

            return $this->view("Home/index");
        }

        private function checkLogin() {
            $db = $this->model("Auth/AuthModel");

            if (!isset($_COOKIE["Yoshino_Token"])) {
                $_COOKIE["Yoshino_Token"] = $this->genToken();
            } else {
                if ($db->isTokenValid($_COOKIE["Yoshino_Token"])) {
                    setcookie("Yoshino_Token", $_COOKIE["Yoshino_Token"], time()+8640000, "/");
                    header("location: /user");
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
    