<?php
    /**
     * Yoshino Project
     * 
     * @license GPL-V3
     * @author  Tianle Xu <xtl@xtlsoft.top>
     * @package Yoshino
     * @link    https://github.com/idawnlight/yoshino/
     * 
     */

    namespace Yoshino\Lib;

    class CheckLoginController extends \X\Controller {

        /**
         * Get the authenticate model.
         *
         * @return \Model\Auth\AuthModel
         * 
         */
        public function getAuthModel(){

            return $this->model("Auth/AuthModel");

        }

        /**
         * Check if the user have logined.
         *
         * @param \X\Request $req
         * 
         * @return bool
         * 
         */
        public function checkLogin($req){

            if(isset($req->data->cookie->Yoshino_Token)){
                $token = $req->data->cookie->Yoshino_Token;
                if (strlen($token) !== 128) {
                    return false;
                }
                if($this->getAuthModel()->isTokenValid($token)){
                    return true;
                }
            }

            return false;

        }

        /**
         * If the user is in user Module
         *
         * @param \X\Request $req
         * 
         * @return bool
         * 
         */
        public function ifInUser($req){

            $uri = $req->uri;

            if ($uri === "/auth/logout" || substr($uri, 0, 5) === "/user" || substr($uri, 0, 10) === "/dashboard") {
                return true;
            } else {
                return false;
            }

        }

        /**
         * If request an API
         *
         * @param \X\Request $req
         *
         * @return bool
         *
         */
        public function ifAPI($req){

            $uri = $req->uri;

            if (substr($uri, -5) === ".json" || substr($uri, -4) === ".png" || substr($uri, 0, 9) === "/textures") {
                return true;
            } else {
                return false;
            }

        }

        /**
         * Get User Permission
         *
         * @prama string $token
         *
         * @return string $permission
         *
         */
        public function getUserPermission($req) {
            $token = $req->data->cookie->Yoshino_Token;
            $permission = $this->getAuthModel()->getUserPermission($token);
            if($permission !== ""){
                return $permission;
            } else {
                return false;
            }
        }

        /**
         * Get Redirect Response
         *
         * @param string $uri
         * 
         * @return \X\Response
         * 
         */
        public function getRedirectResponse(string $uri){

            return $this->response("Redirecting...", ["location" => $uri], 302);

        }

        /**
         * Get Banned Response
         */
        public function getBannedResponse(){

            return $this->response("此账号已被封禁，详情请询问管理员。", [], 403);

        }

        /**
         * Generation for token
         *
         * @return string $token
         *
         */
        public function genToken() {
            $token = $this->randString(128);
            //$this->response("", ["Set-Cookie" => "Yoshino_Token=" . $token]);
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
