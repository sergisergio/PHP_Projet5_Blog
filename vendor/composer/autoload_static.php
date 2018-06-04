<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita5923d9877bcd5b93096d3c8dc527fbe
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Philippe\\Blog\\Model\\Entities\\' => 29,
            'Philippe\\Blog\\Model\\' => 20,
            'Philippe\\Blog\\Core\\' => 19,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'M' => 
        array (
            'Michelf\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Philippe\\Blog\\Model\\Entities\\' => 
        array (
            0 => __DIR__ . '/../..' . '/model/Entities',
        ),
        'Philippe\\Blog\\Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/model',
        ),
        'Philippe\\Blog\\Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Michelf\\' => 
        array (
            0 => __DIR__ . '/..' . '/michelf/php-markdown/Michelf',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita5923d9877bcd5b93096d3c8dc527fbe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita5923d9877bcd5b93096d3c8dc527fbe::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
