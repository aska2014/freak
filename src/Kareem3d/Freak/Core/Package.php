<?php namespace Kareem3d\Freak\Core;

class Package {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var PackageController
     */
    protected $controller;

    /**
     * @param $name
     * @param PackageController $controller
     * @return \Kareem3d\Freak\Core\Package
     */
    public function __construct($name, PackageController $controller)
    {
        $this->name = $name;
        $this->controller = $controller;
    }

    /**
     * @param $name
     * @return bool|string
     */
    public function checkName( $name )
    {
        return strtolower($this->name) === strtolower($name);
    }

    /**
     * @param $view
     * @return mixed|void
     */
    public function getView($view)
    {
        return $this->controller->getView($view);
    }

    /**
     * @param $requestMethod
     * @param $uri
     * @param PackageData $packageData
     * @param array $parameters
     * @return mixed
     */
    public function call($requestMethod, $uri, PackageData $packageData = null, array $parameters = array())
    {
        // First set package data
        $this->controller->setData($packageData);

        // Call the method using the controller
        return $this->controller->call($requestMethod, $uri);
    }
}