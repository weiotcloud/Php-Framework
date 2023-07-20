<?php

namespace Fix\Middleware;

use Fix\Kernel\Url;
use Illuminate\Database\Capsule\Manager;


class Middleware
{


    /**
     * @param null $Request
     */
    public static function __start($Request = null){


        $whoops = new \Whoops\Run;
        $handler = new \Whoops\Handler\PrettyPageHandler;
        $handler->setEditor('phpstorm');

        $whoops->pushHandler($handler);
        $whoops->register();

        if(!Url::getRouter())
            return;

        $capsule = new Manager();

        $capsule->addConnection([
            "driver"        => Url::getSettings()["database"]["driver"],
            "host"          => Url::getSettings()["database"]["host"],
            "database"      => Url::getSettings()["database"]["table"],
            "username"      => Url::getSettings()["database"]["username"],
            "password"      => Url::getSettings()["database"]["password"]
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();


        // Initiation Middleware

    }

    /**
     * @param null $Request
     */
    public static function __finish($Request = null){

        // Completed Middleware

    }


}