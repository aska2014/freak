<?php namespace Kareem3d\Freak\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Kareem3d\Freak\Core\PackageData;
use Kareem3d\Freak\Freak;

class RequestController extends FreakBaseController {

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
     * @param $element
     * @param string $uri
     * @return mixed
     */
    public function element($element, $uri = '')
    {
        $element = $this->freak->findElement($element);

        return $element->call(Request::getMethod(), $uri);
    }

    /**
     * @param $package
     * @param $uri
     * @internal param $method
     * @internal param mixed $
     */
    public function package($package, $uri)
    {
        $package = $this->freak->findPackage($package);

        $packageData = PackageData::make(Input::all());

        return $package->call(Request::getMethod(), $uri, $packageData);
    }

    /**
     * @param $element
     * @param $view
     * @return string
     */
    public function elementView($element, $view)
    {
        $string = View::make("{$this->freak->getName()}::$element.$view")->__toString();

        foreach($this->freak->findElement($element)->getPackages() as $package)
        {
            $string .= (string) $package->getView($view);
        }

        return $string;
    }
}