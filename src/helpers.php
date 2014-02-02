<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

/**
 * Get freak url.
 *
 * @param string $uri
 * @return string
 */
function freakUrl( $uri ){ return URL::to(Config::get('freak::routes.prefix') . '/' . trim($uri, '/')); }

/**
 * @param $uri
 * @return mixed
 */
function freakRedirect( $uri ){ return Redirect::to(freakUrl($uri)); }

/**
 * Check if uri is the current freak url
 *
 * @param $uri
 * @return bool
 */
function freakCurrent( $uri ){

    return (freakPrefix() . '/' . $uri) === Request::path();
}

/**
 * @return string
 */
function freakPrefix()
{
    return trim(Config::get('freak::routes.prefix'), '/');
}

/**
 * @return string
 */
function freakDomain()
{
    return Config::get('freak::routes.domain');
}

/**
 * @return string
 */
function freakUri()
{
    $prefix = freakPrefix();
    $path = Request::path();

    if (substr($path, 0, strlen($prefix)) == $prefix) {
        $path = substr($path, strlen($prefix));
    }

    return trim($path, '/');
}

/**
 * Get route configurations
 *
 * @return array
 */
function freakRouteConfig() {

    $routeConfig['domain'] = Config::get('freak::routes.domain');
    $routeConfig['prefix'] = Config::get('freak::routes.prefix');

    return $routeConfig;
}