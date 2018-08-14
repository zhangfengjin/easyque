<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9f6f7c3e25c4212f4e376f0564476ee1
{
    public static $prefixLengthsPsr4 = array (
        'X' => 
        array (
            'XYLibrary\\' => 10,
        ),
        'P' => 
        array (
            'Predis\\' => 7,
        ),
        'E' => 
        array (
            'Examples\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'XYLibrary\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
            1 => __DIR__ . '/..' . '/php-framework/php-framework/src',
        ),
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
        'Examples\\' => 
        array (
            0 => __DIR__ . '/../..' . '/examples',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9f6f7c3e25c4212f4e376f0564476ee1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9f6f7c3e25c4212f4e376f0564476ee1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
