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

    namespace Yoshino\Middleware;

    class CheckLogin extends \X\Middleware {

        public function handle($event, \X\Request $request){

            if(!$this->app->handler instanceof \X\Handler\Http){
                return;
            }

            $controller = $this->app->boot("\\Yoshino\\Lib\\CheckLoginController");

            $isLogin = $controller->checkLogin($request);
            $isInUser = $controller->ifInUser($request);
            $isAPI = $controller->ifAPI($request);

            if ($isAPI) {
                return;
            }
            if (!$isLogin) {
                $_COOKIE["Yoshino_Token"] = $controller->genToken();
            } else {
                $permission = $controller->getUserPermission($request);
                if ($permission === "banned") {
                    $this->app->handler->response($controller->getBannedResponse());
                    die();
                }
                if (substr($request->uri, 0, 10) === "/dashboard") {
                    if ($permission === "admin") {
                        return;
                    } else {
                        $this->app->handler->response($controller->getRedirectResponse("/user"));
                        die;
                    }
                }
            }
            if($isLogin && $isInUser){
                return;
            }
            if($isLogin){
                $this->app->handler->response($controller->getRedirectResponse("/user"));
                die;
            }
            if($isInUser){
                $this->app->handler->response($controller->getRedirectResponse("/auth/login"));
                die;
            }

        }

        public function response($event, \X\Response $response){

        }

    }