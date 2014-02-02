<?php namespace Kareem3d\Freak\Repositories;

use Kareem3d\Freak\Core\Package;

interface PackageRepository {

    /**
     * @return mixed
     */
    public static function all();

    /**
     * @param \Kareem3d\Freak\Core\Package $package
     * @return mixed
     */
    public static function register(Package $package);

}