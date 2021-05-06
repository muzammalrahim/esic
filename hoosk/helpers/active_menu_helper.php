<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('active_link')) {
    function active_link($controller, $method)
    {
        $CI    = get_instance();
        $class = $CI->router->fetch_class();
        if (!empty($method)) {
            $controller = $controller . '/' . $method;
            $f_method   = $CI->router->fetch_method();
            $class      = $class . '/' . $f_method;
            return     ($class == $controller) ? 'active' : '';
        }else {
            return ($class == $controller) ? 'active' : '';
        }
    }
}
?>