<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb3da990505a25cf523a22d1fce3cb873
{
    public static $files = array (
        'ff6613caab5f924eaaf79842fcf64e9c' => __DIR__ . '/../..' . '/includes/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WEDEVS\\APF\\INCLUDES\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WEDEVS\\APF\\INCLUDES\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb3da990505a25cf523a22d1fce3cb873::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb3da990505a25cf523a22d1fce3cb873::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
