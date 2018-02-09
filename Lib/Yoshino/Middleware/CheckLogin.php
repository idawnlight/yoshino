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

            if($isLogin && $isInUser){
                return;
            }
            if($isLogin){
                $this->app->handler->response($controller->getRedirectResponse("/user"));
                die;
                return;
            }
            if($isInUser){
                $this->app->handler->response($controller->getRedirectResponse("/auth/login"));
                die;
                return;
            }

        }

        public function response($event, \X\Response $response){



        }

    }