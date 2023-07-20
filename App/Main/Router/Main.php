<?php

/*
 *
 *
 *
 *  ___       __   _______   ___  ________  _________
 * |\  \     |\  \|\  ___ \ |\  \|\   __  \|\___   ___\
 * \ \  \    \ \  \ \   __/|\ \  \ \  \|\  \|___ \  \_|
 *  \ \  \  __\ \  \ \  \_|/_\ \  \ \  \\\  \   \ \  \
 *   \ \  \|\__\_\  \ \  \_|\ \ \  \ \  \\\  \   \ \  \
 *    \ \____________\ \_______\ \__\ \_______\   \ \__\
 *     \|____________|\|_______|\|__|\|_______|    \|__|
 *
 * WeIOT Custom Framework
 * Development by Cengiz AKCAN
 * Composer Support
 * Main File : [Main Dir] / App / Main / Router / Main.php
 * Creation Date : 07/20/2023
 * Github Account : https://github.com/weiotcloud
 *
 *
 * */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header ("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language,X-Authorization");

setlocale(LC_MONETARY, 'tr_TR');
date_default_timezone_set('Europe/Istanbul');

session_start();
ob_start();


use Fix\Router\Router;
use FixInternal\Response\Response;


Router::get("/",function (){

    Response::make("Hello, World!","Kurulum Başarılı")->success();

});

Router::notFound(function (){
    Response::make("HATA","Sayfa Bulunamadı")->error();
});
