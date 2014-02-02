<?php namespace Kareem3d\Freak\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class ConfigurationController extends FreakBaseController {

    /**
     * @return mixed
     */
    public function getMenu()
    {
        $menu = Config::get('freak::paths.configurations.menu');

        return Response::json(json_decode(file_get_contents($menu)));
    }

}