<?php namespace Kareem3d\Freak\Repositories;

use Kareem3d\Freak\Core\Element;

interface ElementRepository {

    /**
     * @return mixed
     */
    public static function all();

    /**
     * @param \Kareem3d\Freak\Core\Element $element
     * @return mixed
     */
    public static function register(Element $element);

}