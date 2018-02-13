<?php
    /**
     * XPHP Configure File
     * 
     * You can add your providers here.
     * 
     */
    return function ($App) {

        global $Base, $Environment, $Version;
        $Base = $App->config["Route"]["Base"];
        $Environment = $App->config["Yoshino"]["Environment"];
        $Version = $App->config["Y"];

        $App->boot('\X\Middleware\Filter');

        $App->container->get("Core.View")->addHelper("file", function ($file){
            global $Environment, $Version;
            if ($Environment === "develop") $v="?v=" . date("Y-m-d"); else $v="?v=".$Version;
            return "/Static/".$file.$v;
        });

        $App->container->get("Core.View")->addHelper("trans", function ($name){
            static $language = "zh_CN";
            static $dir = "";
            static $index, $page, $sidebar, $auth, $user, $dashboard;
            static $parts = ["page", "index", "sidebar", "auth", "user", "dashboard"];
            static $init = true;

            if ($init) {
                $dir = SysDir . "Var/Lang/" . $language . "/";
                foreach ($parts as $part) {
                    $$part = json_decode(file_get_contents($dir . $part . ".json"));
                }
                $init = false;
                unset($part);
            }

            list($part, $expression)  = explode(".", $name);

            return $$part->$expression;
        });

        $App->container->get("Core.View")->addHelper("path", function ($name){
            static $router = [
                "index" => "/",
                "login" => "/auth/login",
                "reg"   => "/auth/reg",
                "sign-out" => "/auth/logout",

                "user"  => "/user",
                "user.player" => "/user/player",
                "user.texture" => "/user/texture",

                "dashboard" => "/dashboard",
                "dashboard.user" => "/dashboard/user",

                "github"=> "https://github.com/idawnlight/yoshino"
            ];

            global $Base;
            return $Base . $router[$name];
        });

        $App->boot("\\Yoshino\\Middleware\\CheckLogin");
        

    };