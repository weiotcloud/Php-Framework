<?php


namespace Fix\Support;


class Header
{


    public static function serialCode() {

        return rand(111,999).rand(123,987).rand(000,999);

    }

    /**
     * @param string $AUTH_USER
     * @param string $AUTH_PASS
     * @return null
     */
    public static function httpAut($AUTH_USER = "admin", $AUTH_PASS = "admin"){

        self::noCache();

        if
        (
            (
                empty($_SERVER["PHP_AUTH_USER"]) && empty($_SERVER["PHP_AUTH_PW"])) ||
                $_SERVER["PHP_AUTH_USER"] != $AUTH_USER || $_SERVER["PHP_AUTH_PW"]   != $AUTH_PASS
        ) :
            header('HTTP/1.1 401 Authorization Required');
            header('VOBO-Authenticate: Basic realm="Access denied"');
            return null;
        endif;

    }

    public static function noCache(){

        header("Expires: 0");
        header("Pragma: no-cache");
        header("Cache-Control: no-cache,no-store,max-age=0,s-maxage=0,must-revalidate");

    }

    public static function notFound(){

        header("HTTP/1.1 404 Not Found");
        return null;

    }
    public static function serverError(){

        header("HTTP/1.1 505 Not Found");
        return null;

    }

    public static function notFoundResponse($string = null){

        header("HTTP/1.1 404 Not Found");

        return $string;

    }

    /**
     * @param null $setTarget
     */
    public static function redirect($setTarget = null){

        header("Location: ".$setTarget);

    }

    /**
     * @param null $setType
     */
    public static function content($setType = null){

        header("Content-type: ".$setType);

    }

    /**
     * @param null $provider
     * @param array $list
     * @param string $message
     * @return bool
     * @throws \Exception
     */
    public static function checkParameter($provider = null, $list = [], $message = "Parametre hatası"){

        foreach ($list as $key => $item){

             if(!isset($provider[$item])){
                 throw new \Exception($message);
             }

        }

        return true;

    }

    /**
     * @param null $key
     * @param bool $filterStatus
     * @param callable|null $filter
     * @return mixed
     */
    public static function post($key = null, $filterStatus = false, callable $filter = null){

        return $filterStatus ? $filter($_POST[$key]) : $_POST[$key];

    }

    /**
     * @param null $key
     * @param bool $filterStatus
     * @param callable|null $filter
     * @return mixed
     */
    public static function get($key = null, $filterStatus = false, callable $filter = null){

        return $filterStatus ? $filter($_GET[$key]) : $_GET[$key];

    }


    /**
     * @param null $provider
     * @param array $list
     * @return bool
     * @param string $message
     * @throws \Exception
     */
    public static function checkValue($provider = null, $list = [], $message = "Parametre hatası"){

        foreach ($list as $key => $item)
             if(strlen($provider[$item]) === 0){
                 throw new \Exception($message);
             }
        return true;
    }

    public static function jsonResult(...$parameters){

        header('Content-Type: application/json');

        die(exit(
            json_encode(
                [
                    "status"    => $parameters[0],
                    "title"     => $parameters[1],
                    "message"   => $parameters[2],
                    "data"      => $parameters[3] ?? [],
                ]
            )
        ));

    }

}