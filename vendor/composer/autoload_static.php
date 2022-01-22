<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit81a33fe6ae270515f1b72c5d7a3ca0f6
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Alex\\ManagementSystem\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Alex\\ManagementSystem\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit81a33fe6ae270515f1b72c5d7a3ca0f6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit81a33fe6ae270515f1b72c5d7a3ca0f6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit81a33fe6ae270515f1b72c5d7a3ca0f6::$classMap;

        }, null, ClassLoader::class);
    }
}