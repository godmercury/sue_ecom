<?php

$router = new AltoRouter;

try {
    if (!empty($router)) {
        $router->map('GET', '/', 'App\Controllers\IndexController@show', 'home');

        // for admin routes
        $router->map('GET', '/admin', 'App\Controllers\Admin\DashboardController@show', 'dashboard');
        $router->map('POST', '/admin', 'App\Controllers\Admin\DashboardController@get', 'admin_form');

        // products management
        $router->map('GET', '/admin/products/categories', 'App\Controllers\Admin\ProductCategoryController@show', 'product_category');
        $router->map('POST', '/admin/products/categories', 'App\Controllers\Admin\ProductCategoryController@store', 'product_category');
    } else {
        new Exception('empty route');
    }
} catch (Exception $e) {
    new Exception('no routing');
}



/*
$match = $router->match();

if ($match) {

    list($controller, $method) = explode('@', $match['target']);

    require_once __DIR__ . '/../controllers/BaseController.php';
    require_once __DIR__ . '/../controllers/IndexController.php';

    if(is_callable(array(new $controller, $method))) {
        call_user_func_array(array(new $controller, $method), array());
    } else {
        echo 'The method ' . $method. ' is not defined in '. $controller;
    }

} else {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'Page not found';
}
*/
/*
$router->map('GET', '/', '', 'home');

$match = $router->match();

if ($match) {
    require_once __DIR__ . '/../controllers/BaseController.php';
    require_once __DIR__ . '/../controllers/IndexController.php';


    $index = new \App\Controllers\IndexController();
    $index->show();
} else {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'Page not found';
}
*/