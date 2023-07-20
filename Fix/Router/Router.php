<?php

   namespace Fix\Router;


   use Fix\Packages\Assets\Assets;
   use Fix\Support\Header;

   class Router
   {
       const PATTERN =
           [
               "{number}",
               "{string}",
               "{parameter}",
               "."
           ];

       const DATA =
           [
               "{number}",
               "{string}",
               "{parameter}"
           ];

       const REPLACE =
           [
               "[0-9]*",
               "[a-zA-Z]*",
               "[a-zA-Z0-9_:-]*",
               ".*\.*"
           ];

       const REGEX                 = "@^REGEX$@";
       const REGEX_DATA            = "|REGEX|U";
       const POST                  = "POST";
       const GET                   = "GET";
       const PUT                   = "PUT";
       const DELETE                = "DELETE";
       const HEAD                  = "HEAD";
       const OPTIONS               = "OPTIONS";
       const PATCH                 = "PATCH";

       protected static $writeRoute        = [];
       protected static $getMethod         = null;
       protected static $urlParameter      = null;
       public    static  $groupPrefix          = [];

       public function __construct($group = null) {

           if($group !== null)
               self::$groupPrefix[] = $group;

           return $this;
       }

       public static function group($group = null,callable $callback = null){

           $newClass               = new self($group);

           return $callback($newClass,$newClass::$groupPrefix);

       }
       /**
        * @param null $urlParameter
        * @return mixed
        */
       protected static function getReplacePattern($urlParameter = null){
           return str_replace(self::PATTERN,self::REPLACE,$urlParameter);
       }

       /**
        * @param null $getPattern
        * @return false|int
        */
       protected static function getReturnPattern($getPattern = null){
           return str_replace(self::DATA,"(.*?)",$getPattern);
       }

       /**
        * @param null $urlParameter
        * @param string $setMethod
        * @return mixed
        */
       public static function withReplaceUrl($urlParameter = null, $setMethod = self::GET){

           $writeREGEX         =   str_replace("REGEX",self::getReplacePattern(sprintf("%s%s",implode("",self::$groupPrefix),$urlParameter)),self::REGEX);
           $writeDATA          =   str_replace("REGEX",self::getReturnPattern( sprintf("%s%s",implode("",self::$groupPrefix),$urlParameter)),self::REGEX_DATA);
           preg_match_all($writeDATA,self::getRoute(),$export);
           $dataReturn         =   [$writeREGEX,$writeDATA,$setMethod,"DATA" => $export];
           self::$writeRoute[] =   $dataReturn;
           return $dataReturn;
       }

       /**
        * @return null
        */
       protected static function getMethod(){
           self::$getMethod =  $_SERVER['REQUEST_METHOD'];
           return self::$getMethod;
       }

       /**
        * @return null
        */
       protected static function getRoute(){
           self::$urlParameter =  "/".rtrim(str_replace([",","*","'",'"'],"",$_GET["url"] ?? ""),"/");
           return self::$urlParameter;
       }

       /**
        * @param null $setRoute
        * @param string $setMethod
        * @return bool
        */
       public static function isMatch($setRoute = null, $setMethod = "GET"){
           return ( ( (self::getMethod() === $setMethod)  || $setMethod === "ANY" ) &&  (preg_match($setRoute,self::getRoute())) ) ? true : false;
       }


       /**
        * @param null $setRoute
        * @param string $setMethod
        * @return bool
        */
       public static function isMatchErrorMethod($setRoute = null, $setMethod = "GET"){
           return ( (self::getMethod() !== $setMethod) &&  (preg_match($setRoute,self::getRoute())) ) ? true : false;
       }

       /**
        * @param array $Parameters
        * @return array
        */
       protected static function setCallParameters(array $Parameters = []) {
           $setParameters = [];
           foreach ($Parameters as $getPar):
               $setParameters[] = $getPar[0];
           endforeach;
           unset($setParameters[0]);
           return $setParameters;
       }


       /**
        * @param array ...$__setParameter
        */
       protected static function setTwoChange(...$__setParameter) {

           if($__setParameter[0] === "FUNCTION"):
               call_user_func_array(
                   $__setParameter[2],
                   self::setCallParameters(self::withReplaceUrl($__setParameter[1],$__setParameter[3])["DATA"])
               );
           elseif ($__setParameter[0] === "OBJECT"):
               call_user_func_array(
                   [$__setParameter[2],$__setParameter[3]],
                   self::setCallParameters(self::withReplaceUrl($__setParameter[1],$__setParameter[4])["DATA"])
               );
           endif;

       }

       /**
        * @param null $urlParameter
        * @param null $target
        * @param null $function
        */
       public static function redirect($urlParameter = null, $target = null, $function = null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"GET")[0],"GET")):
               Header::redirect($target);
               return;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"GET")[0],"GET")){
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "ANY"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "ANY"
                       );
                   endif;
               }else{
                   return false;
               }
               return false;
           endif;
       }

       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param null $function
        */
       public static function get($urlParameter = null, $parameter = null, $function = null){

           if(self::isMatch(self::withReplaceUrl($urlParameter,"GET")[0],"GET")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "GET"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "GET"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"GET")[0],"GET")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "GET"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "GET"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }


       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param callable|null $function
        */
       public static function post($urlParameter = null, $parameter = null, $function = null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"POST")[0],"POST")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "POST"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "POST"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"POST")[0],"POST")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "POST"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "POST"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }


       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param null $function
        */
       public static function delete($urlParameter = null, $parameter = null, $function = null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"DELETE")[0],"DELETE")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "DELETE"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "DELETE"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"DELETE")[0],"DELETE")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "DELETE"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "DELETE"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }


       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param null $function
        */
       public static function put($urlParameter = null, $parameter = null, $function = null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"PUT")[0],"PUT")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "PUT"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "PUT"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"PUT")[0],"PUT")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "PUT"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "PUT"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }


       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param null $function
        */
       public static function head($urlParameter = null, $parameter = null, $function= null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"HEAD")[0],"HEAD")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "HEAD"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "HEAD"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"HEAD")[0],"HEAD")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "HEAD"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "HEAD"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }


       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param null $function
        */
       public static function patch($urlParameter = null, $parameter = null, $function = null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"PATCH")[0],"PATCH")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "PATCH"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "PATCH"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"PATCH")[0],"PATCH")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "PATCH"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "PATCH"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }


       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param null $function
        */
       public static function options($urlParameter = null, $parameter = null, $function = null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"OPTIONS")[0],"OPTIONS")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "OPTIONS"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "OPTIONS"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"OPTIONS")[0],"OPTIONS")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "OPTIONS"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "OPTIONS"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }

       /**
        * @param null $urlParameter
        * @param null $parameter
        * @param null $function
        */
       public static function any($urlParameter = null, $parameter = null, $function = null){
           if(self::isMatch(self::withReplaceUrl($urlParameter,"ANY")[0],"ANY")):
               if(is_callable($parameter)):
                   self::setTwoChange(
                       "FUNCTION",
                       $urlParameter,
                       $parameter,
                       "ANY"
                   );
               else:
                   self::setTwoChange(
                       "OBJECT",
                       $urlParameter,
                       $parameter[0],
                       $parameter[1],
                       "ANY"
                   );
               endif;
           else:
               if($function === null)
                   return false;
               if(self::isMatchErrorMethod(self::withReplaceUrl($urlParameter,"ANY")[0],"ANY")):
                   if(is_callable($function)):
                       self::setTwoChange(
                           "FUNCTION",
                           $urlParameter,
                           $function,
                           "ANY"
                       );
                   else:
                       self::setTwoChange(
                           "OBJECT",
                           $urlParameter,
                           $function[0],
                           $function[1],
                           "ANY"
                       );
                   endif;
               else:
                   return false;
               endif;
           endif;

       }


       /**
        * @param  $function
        */
       public static function notFound($function){

           $count = 0;
           foreach (self::$writeRoute as $routs):
               if((preg_match($routs[0],self::getRoute()))) : $count +=1; endif;
           endforeach;
           if($count === 0) :
               call_user_func_array( $function, [self::getRoute()] );
           endif;
       }

       /**
        * @param callable $function
        * @return mixed
        */
       public static function export(callable $function){

           return call_user_func_array(
               $function,
               [self::$writeRoute,json_encode(self::$writeRoute)]
           );
       }


   }