<?php namespace Kareem3d\Freak\Repositories;

use Kareem3d\Freak\Core\Package;

class PackageArray implements PackageRepository {

    /**
     * @var Package[]
     */
    protected static $registered = array();

    /**
     * @return Package[]
     */
    public static function all()
    {
        return static::$registered;
    }

    /**
     * @param Package $package
     * @return mixed|void
     */
    public static function register( Package $package )
    {
        static::$registered[] = $package;
    }
}