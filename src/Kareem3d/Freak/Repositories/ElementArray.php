<?php namespace Kareem3d\Freak\Repositories;

use Kareem3d\Freak\Core\Element;

class ElementArray implements ElementRepository {

    /**
     * @var Element[]
     */
    protected static $registered = array();

    /**
     * @return Element[]
     */
    public static function all()
    {
        return static::$registered;
    }

    /**
     * @param \Kareem3d\Freak\Core\Element $element
     * @return mixed|void
     */
    public static function register( Element $element )
    {
        static::$registered[] = $element;
    }

}