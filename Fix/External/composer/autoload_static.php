<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc8df7723d6b69d85daf8ef986ab5870e
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Fix\\' => 4,
            'FixInternal\\' => 12,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Fix\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/Fix',
        ),
        'FixInternal\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/Fix/Packages',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Fix\\Exception\\Error' => __DIR__ . '/../../..' . '/Fix/Exception/Error.php',
        'Fix\\Kernel\\Filter' => __DIR__ . '/../../..' . '/Fix/Kernel/Filter.php',
        'Fix\\Kernel\\Kernel' => __DIR__ . '/../../..' . '/Fix/Kernel/Kernel.php',
        'Fix\\Kernel\\Url' => __DIR__ . '/../../..' . '/Fix/Kernel/Url.php',
        'Fix\\Middleware\\Middleware' => __DIR__ . '/../../..' . '/Fix/Middleware/Middleware.php',
        'Fix\\Mode\\Request' => __DIR__ . '/../../..' . '/Fix/Mode/Request.php',
        'Fix\\Packages\\Assets\\Assets' => __DIR__ . '/../../..' . '/Fix/Packages/Assets/Assets.php',
        'Fix\\Packages\\Assets\\Support' => __DIR__ . '/../../..' . '/Fix/Packages/Assets/Support.php',
        'Fix\\Packages\\Console\\Console' => __DIR__ . '/../../..' . '/Fix/Packages/Console/Console.php',
        'Fix\\Packages\\Console\\Map' => __DIR__ . '/../../..' . '/Fix/Packages/Console/Map.php',
        'Fix\\Packages\\Console\\Request' => __DIR__ . '/../../..' . '/Fix/Packages/Console/Request.php',
        'Fix\\Packages\\Database\\Database' => __DIR__ . '/../../..' . '/Fix/Packages/Database/Database.php',
        'Fix\\Packages\\Model\\Model' => __DIR__ . '/../../..' . '/Fix/Packages/Model/Model.php',
        'Fix\\Router\\Router' => __DIR__ . '/../../..' . '/Fix/Router/Router.php',
        'Fix\\Settings\\App' => __DIR__ . '/../../..' . '/Fix/Settings/App.php',
        'Fix\\Settings\\Kernel' => __DIR__ . '/../../..' . '/Fix/Settings/Kernel.php',
        'Fix\\Support\\Header' => __DIR__ . '/../../..' . '/Fix/Support/Header.php',
        'Fix\\Support\\Json' => __DIR__ . '/../../..' . '/Fix/Support/Json.php',
        'Fix\\Support\\Support' => __DIR__ . '/../../..' . '/Fix/Support/Support.php',
        'Fix\\Support\\Translate' => __DIR__ . '/../../..' . '/Fix/Support/Translate.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc8df7723d6b69d85daf8ef986ab5870e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc8df7723d6b69d85daf8ef986ab5870e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc8df7723d6b69d85daf8ef986ab5870e::$classMap;

        }, null, ClassLoader::class);
    }
}
