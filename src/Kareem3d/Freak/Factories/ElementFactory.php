<?php namespace Kareem3d\Freak\Factories;


use Illuminate\Support\Facades\App;
use Kareem3d\Freak\Core\Element;
use Kareem3d\Freak\Core\Package;
use Kareem3d\Freak\Freak;

class ElementFactory {

    /**
     * @var Freak
     */
    protected $freak;

    /**
     * @param Freak $freak
     */
    public function __construct(Freak $freak)
    {
        $this->freak = $freak;
    }

    /**
     * @return array
     */
    public function defaultOptions()
    {
        return array(

            'controller' => function($name)
            {
                return 'Freak'.ucfirst($name).'Controller';
            },

            'packages' => array()
        );
    }

    /**
     * @param $name
     * @param $options
     * @return array
     */
    protected function mergeDefault($name, $options)
    {
        foreach(static::defaultOptions() as $key => $value)
        {
            if(isset($options[$key])) continue;

            if(is_callable($value))
            {
                $value = call_user_func($value, $name);
            }

            $options[$key] = $value;
        }

        return $options;
    }

    /**
     * @param array $array
     * @return Element[]
     */
    public function fromArray( array $array )
    {
        $elements = array();

        foreach($array as $name => $options)
        {
            $options = $this->mergeDefault($name, $options);

            // Create element with name and controller
            $element = new Element($name, App::make($options['controller']));

            // Set packages for this element
            $element->setPackages($this->getPackages($options['packages']));

            $elements[] = $element;
        }

        return $elements;
    }


    /**
     * @param $packagesArray
     * @return Package[]
     */
    public function getPackages($packagesArray)
    {
        $packages = array();

        foreach($packagesArray as $packageName)
        {
            if($package = $this->freak->findPackage($packageName))
            {
                $packages[] = $package;
            }
        }

        return $packages;
    }
}