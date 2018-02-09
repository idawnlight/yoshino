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
         * @return string
         * 
         */
        public function ifInUser($req){

            $uri = $req->uri;
            return (substr($uri, 0, 5) === "/user" || $uri === "/auth/logout");

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

    }
