<?php namespace Kareem3d\Freak\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Kareem3d\Helper\Helper;
use Kareem3d\Responser\Responser;

class LoginController extends FreakBaseController {

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return View::make('freak::login.index');
    }

    /**
     * @return mixed
     */
    public function postIndex()
    {
        // Attempt to login with user inputs
        if(Auth::attempt($this->getUserInputs(), Input::has('Login.remember')))
        {
            return Responser::success('You have logged in successfully.', freakUrl('/'));
        }

        return Responser::errors('Login information are incorrect.');
    }

    /**
     * @return mixed
     */
    protected function getUserInputs()
    {
        return Helper::instance()->arrayGetKeys(Input::get('Login', array()), array('email', 'password'));
    }
}