<?php namespace Kareem3d\Freak\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class FreakController extends FreakBaseController {

    /**
     * @return mixed
     */
    public function index()
    {
        $authUser = Auth::user();

        return View::make('freak::index', compact('authUser'));
    }

    /**
     * @param $view
     */
    public function page($view)
    {
        return View::make('freak::pages.'. $view);
    }
}