<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6cf18101bdf6a3460f27dfeb9ac042d9
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WeDevs\\MagicLogin\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WeDevs\\MagicLogin\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit6cf18101bdf6a3460f27dfeb9ac042d9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6cf18101bdf6a3460f27dfeb9ac042d9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6cf18101bdf6a3460f27dfeb9ac042d9::$classMap;

        }, null, ClassLoader::class);
    }
}
