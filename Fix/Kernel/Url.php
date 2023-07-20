<?php

namespace Fix\Kernel;

use Fix\Settings\Kernel;
use Fix\Settings\App;
use Fix\Support\Support;

class Url {

    /**
     * @return mixed
     */
    public static function detectionUrl($Request = null){

        return Kernel::MULTIPLE_STATUS ? $_SERVER["HTTP_HOST"] : Kernel::DEFAULT_FOLDER;

    }

    /**
     * @return mixed
     */
    public static function detectionParameter($Request = null){

        return $_SERVER["REQUEST_URI"];

    }


    public static function chckDomainWithWildCardDomainMiddileware($setApp = null) {

        $export = [];


        foreach (App::APP as $key => $item){
            if(preg_match("/[*]/i",$key)){
                if(preg_match(sprintf("/%s/i",str_replace("*","(.*?)",$key)),$setApp,$matches)){
                    $export = [
                        "prefix"        => $matches[1],
                        "result"        => str_replace("*",$matches[1],$key),
                        "pattern"       => $key,
                        "wildcard"      => true,
                        "accept"        => true
                    ];
                }
            }else{
                if(array_key_exists($setApp,App::APP)){
                    $export = [
                        "result"        => false,
                        "pattern"       => $key,
                        "prefix"        => false,
                        "wildcard"      => false,
                        "accept"        => true,
                    ];
                }
            }
        }

        return $export;

    }

    /**
     * @param null $setApp
     * @return bool
     */
    public static function detectionApplyApp($setApp = null){

        return self::chckDomainWithWildCardDomainMiddileware($setApp)["accept"] ?? false;

    }

    /**
     * @return bool
     */
    public static function getRouter($Request = null){

        return (self::detectionApplyApp(self::detectionUrl($Request))) ? true : false;
    }

    /**
     * @return array
     */
    public static function getSettings($Request = null){

        return self::getRouter() ? App::APP[self::detectionUrl($Request)] : [];

    }

    /**
     * @return null|void
     */
    protected static function isAppFolder($Request = null){

        is_dir( Kernel::APPLICATIONS_MASTER_FOLDER. Kernel::SLASH. self::getSettings($Request)["folder"] ) ? null : Support::__error("NOT FOUND APPLICATION MASTER FOLDER");

    }

    /**
     * @return null|void
     */
    protected static function isAppRouter($Request = null){

       file_exists(
            Kernel::APPLICATIONS_MASTER_FOLDER.
            Kernel::SLASH.
            self::getSettings($Request)["folder"].
            Kernel::SLASH.Kernel::ROUTERS_FOLDER.Kernel::SLASH.
            self::getSettings($Request)["router"].
            Kernel::CORE_EXTENSION
        ) ? null : Support::__error("NOT FOUND APPLICATION MASTER ROUTER");

    }

    /**
     * @param null $Request
     */
    protected static function getLoad($Request = null){

        include
        (
            Kernel::APPLICATIONS_MASTER_FOLDER.
            Kernel::SLASH.
            self::getSettings($Request)["folder"].
            Kernel::SLASH.Kernel::ROUTERS_FOLDER.Kernel::SLASH.
            self::getSettings($Request)["router"].
            Kernel::CORE_EXTENSION
        );

    }

    /**
     * @Mixed Include
     */
    public static function getSystem($Request = null){

        // Application Folder Control
        self::isAppFolder($Request);

        // Application Master Router control
        self::isAppRouter($Request);

        // Application Include Master Router
        self::getLoad($Request);

    }

}