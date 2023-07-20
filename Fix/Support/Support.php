<?php

namespace Fix\Support;

use Fix\Kernel\Url;
use Fix\Router\Router;
use Fix\Settings\App;

class Support
{


    const POST                  = "POST";
    const GET                   = "GET";
    const PUT                   = "PUT";
    const DELETE                = "DELETE";
    const HEAD                  = "HEAD";
    const OPTIONS               = "OPTIONS";
    const PATCH                 = "PATCH";

    /**
     * @param null $Request
     */
    public static function __error($Request = null){

         die(exit(json_encode([$Request])));

    }

    /**
     * @param null $Request
     */
    public static function __notFound($Request = null){

        Header::notFound();

    }

    /**
     * @param null $Request
     */
    public static function __maintenance($Request = null){

        Header::notFound();

    }

    /**
     * @param null $Request
     */
    protected static function __errorDebug($Request = null){

        register_shutdown_function( function (){
            error_get_last() ?  die(json_encode(error_get_last())) : null;
        });

    }


    public static function __httpsControl($Request = null){

        if(Url::getSettings()["https"]):

            if(!isset($_SERVER['HTTPS'])):

                Header::redirect("https://".$_SERVER['HTTP_HOST'].($_SERVER["REQUEST_URI"] ?? ""));

            endif;

        endif;

    }


    /**
     * @param null $Request
     */
    protected static function __autoLoader($Request = null){

        foreach ( Url::getSettings()["autoLoadClass"] as $__Config ):
            new $__Config($Request);
        endforeach;

    }

    /**
     * @param null $Request
     */
    public static function __getLoad($Request = null){

        // Error Debug Screen
        self::__errorDebug($Request);

        // Maintenance Mode
        self::__httpsControl($Request);

        // Auto Class Loader
        self::__autoLoader($Request);


    }

}