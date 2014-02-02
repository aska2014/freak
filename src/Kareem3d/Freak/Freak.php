<?php namespace Kareem3d\Freak;

use Kareem3d\Freak\Core\Package;
use Kareem3d\Freak\Core\Element;

class Freak {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var Package[]
     */
    protected $packages;

    /**
     * @var Element[]
     */
    protected $elements = array();

    /**
     * @param $name
     * @param $password
     * @param Element[] $elements
     * @param Package[] $packages
     * @return Freak
     */
    public function __construct($name, $password, array $elements, array $packages)
    {
        $this->name     = $name;
        $this->password = $password;
        $this->elements = $elements;
        $this->packages = $packages;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $password
     * @return mixed
     */
    public function checkPassword($password)
    {
        return $this->password = $password;
    }

    /**
     * @return \Kareem3d\Freak\Core\Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @return \Kareem3d\Freak\Core\Package[]
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param Element[] $elements
     */
    public function addElements( array $elements )
    {
        $this->elements = array_merge($this->elements, $elements);
    }

    /**
     * @param Package $package
     */
    public function addPackage(Package $package)
    {
        $this->packages[] = $package;
    }

    /**
     * @param $name
     * @return \Kareem3d\Freak\Core\Package
     */
    public function findPackage( $name  )
    {
        foreach($this->getPackages() as $package)
        {
            if($package->checkName($name))

                return $package;
        }
    }

    /**
     * @param $name
     * @return Element|null
     */
    public function findElement( $name )
    {
        foreach($this->getElements() as $element)
        {
            if($element->checkName($name))

                return $element;
        }
    }

    /**
     * @param $name
     * @param callable $closure
     * @return mixed
     */
    public function modifyElement( $name, \Closure $closure )
    {
        if($element = $this->findElement($name))
        {
            return call_user_func_array($closure, array($element));
        }
    }
}