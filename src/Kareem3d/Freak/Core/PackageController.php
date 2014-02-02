<?php namespace Kareem3d\Freak\Core;

abstract class PackageController extends Controller {

    /**
     * @var PackageData
     */
    protected $data;

    /**
     * @param $data
     */
    public function setData( $data )
    {
        $this->data = $data;
    }

    /**
     * Show form view
     *
     * @return mixed
     */
    public abstract function showForm();

    /**
     * Show detail view
     *
     * @return mixed
     */
    public abstract function showDetail();


    /**
     * @param $view
     * @return mixed|void
     */
    public function getView($view)
    {
        if($view == 'form') return $this->showForm();

        if($view == 'one')  return $this->showDetail();
    }
}