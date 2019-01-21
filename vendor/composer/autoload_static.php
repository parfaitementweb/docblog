<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2335767537eaa5a5baa17acea8a8c674
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Parfaitementweb\\DocBlog\\Tests\\' => 30,
            'Parfaitementweb\\DocBlog\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Parfaitementweb\\DocBlog\\Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'Parfaitementweb\\DocBlog\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2335767537eaa5a5baa17acea8a8c674::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2335767537eaa5a5baa17acea8a8c674::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
