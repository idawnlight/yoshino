<?php
    $Yoshino = [
        "SaveTexturesToDB" => true // 将材质以 base64 保存至数据库

    ];

    $configure = [
        "SysDir"  => SysDir,
        "Path"    => [
            "Route"       => "Var/Route/",
            "Application" => "App/","Template"    => "Var/Template/"
            ,
            "Cache"       => "Var/Cache/",
            "Log"         => [
                "Info"      => "Var/Log/info.log",
                "Error"     => "Var/Log/error.log"
            ]
        ], 
        "View"    => [
            "Start"    => "{{",
            "End"      => "}}",
            "ExtName"  => ".tpl",
            "Template" => "default",
            "Cache"    => false
        ],
        "Database"=> [
            'connection_string' => 'mysql:host=127.0.0.1;dbname=yoshino;charset=utf8', //DSN
            'driver_options'    => array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'), //PDO Option
            'username'          => 'yoshino', //用户名 username
            'password'          => 'yoshino', //密码 password
            'logging'           => true, //开启Query日志 Enable Query Log
            'caching'           => true, //开启缓存 Enable Cache
            'caching_auto_clear'=> true //自动清理缓存 Auto Clear Cache
        ],
        "Route"   => [
            "Base"     => ""
        ],
        "Version" => X,
        "Debug"   => true
    ];

    $configure["Yoshino"] = $Yoshino;

    return $configure;