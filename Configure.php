<?php
    $Yoshino = [
        "Password" => [
            "Encryption" => "salted2sha256", // md5 | salted2md5 | sha256 | salted2sha256 | sha512 | salted2sha512
            "Salt" => "69249f9626a4ce1488b6a6c8fb7919b5" // 盐，默认为 69249f9626a4ce1488b6a6c8fb7919b5（"yoshino" 的 md5），建议脸滚键盘创造一个随机字符串
        ],
        "Textures" => [
            "SaveToDB" => true, // 将材质以 base64 保存至数据库（同时保存一份至本地）
            "ReadFromDB" => false // 从数据库中读取材质数据
            // 当有写入权限且数据库较小时，不建议开启 SaveToDB 及 ReadFromDB
        ]
    ];

    $configure = [
        "SysDir"  => SysDir,
        "Path"    => [
            "Route"       => "Var/Route/",
            "Application" => "App/",
            "Template"    => "Var/Template/",
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