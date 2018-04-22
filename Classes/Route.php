<?php

class Route
{
    public static $validRoutes = array();

    public static function set($route, $function){
        self::$validRoutes[] = $route;

        if(!isset($_GET['url']))
            $_GET['url'] = 'index';
            if ($_GET['url'] == $route)
                $function->__invoke();

    }
}