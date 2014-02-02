<?php namespace Kareem3d\Freak\Core;

use Illuminate\Support\Str;
use Kareem3d\Responser\Responser;

abstract class Controller {

    /**
     * @param $messages
     * @return mixed
     */
    public function success($messages)
    {
        return Responser::success($messages);
    }

    /**
     * @param $messages
     * @return mixed
     */
    public function errors($messages)
    {
        return Responser::errors($messages);
    }

    /**
     * @param $requestMethod
     * @param $uri
     * @return mixed
     */
    public function call($requestMethod, $uri)
    {
        list($method, $parameters) = $this->getMethodNameAndParameters($requestMethod, $uri);

        return call_user_func_array(array($this, $method), $parameters);
    }

    /**
     * @param $requestMethod
     * @param $uri
     * @return string
     */
    public function getMethodNameAndParameters($requestMethod, $uri)
    {
        $uri = trim($uri, '/');

        $requestMethod = strtolower($requestMethod);
        $uriPieces = $uri == '' ? array() : explode('/', $uri);

        $method = '';
        $parameters = array();

        if(empty($uriPieces))
        {
            if($requestMethod == 'get')
            {
                $method = 'index';
            }
            elseif($requestMethod == 'post')
            {
                $method = 'store';
            }
        }

        elseif(is_numeric($uriPieces[0]))
        {
            $parameters[] = $uriPieces[0];

            if($requestMethod == 'get')
            {
                $method = 'show';
            }
            elseif($requestMethod == 'post' || $requestMethod == 'put')
            {
                $method = 'update';
            }
            elseif($requestMethod == 'delete')
            {
                $method = 'destroy';
            }
        }
        else
        {
            $method = $requestMethod . Str::camel(array_shift($uriPieces));
            $parameters = $uriPieces;
        }

        return array($method, $parameters);
    }
}