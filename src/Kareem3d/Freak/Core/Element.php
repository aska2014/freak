<?php namespace Kareem3d\Freak\Core;

use Illuminate\Support\Str;

class Element {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var ElementController
     */
    protected $controller;

    /**
     * @var Package[]
     */
    protected $packages = array();

    /**
     * @param $name
     * @param ElementController $controller
     * @return \Kareem3d\Freak\Core\Element
     */
    public function __construct( $name, ElementController $controller )
    {
        $this->name = $name;
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return strtolower($this->name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function checkName( $name )
    {
        return strtolower($this->name) === strtolower($name);
    }

    /**
     * @param \Kareem3d\Freak\Core\Package $package
     */
    public function addPackage($package)
    {
        $this->packages[] = $package;
    }

    /**
     * @param PackageInterface[] $packages
     */
    public function setPackages( $packages )
    {
        $this->packages = $packages;
    }

    /**
     * @return \Kareem3d\Freak\Core\Package[]
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param $name
     * @return Package|null
     */
    public function getPackage( $name )
    {
        foreach($this->getPackages() as $package)
        {
            if($package->checkName($name)) return $package;
        }
    }

    /**
     * @param ElementController $controller
     */
    public function setController(ElementController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return \Kareem3d\Freak\Core\ElementController
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param $requestMethod
     * @param $uri
     * @return mixed
     * @todo Handle permissions
     */
    public function call($requestMethod, $uri)
    {
        return $this->controller->call($requestMethod, $uri);
    }
}