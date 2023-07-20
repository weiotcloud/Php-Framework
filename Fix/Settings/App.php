<?php


namespace Fix\Settings;

use Fix\Support\Support;

class App
{

    const APP =
        [
            "www" => [
                "folder"                => "Main",
                "router"                => "Main",
                "https"                 => false,
                "maintenance"           => false,
                "autoLoadClass"         => [],
                "database"              =>
                    [
                        "driver"        => "mysql",
                        "host"          => "localhost",
                        "username"      => "",
                        "password"      => "",
                        "table"         => "",
                        "charset"       => "utf8",
                        "prefix"        => null
                    ]
            ],
        ];

}

