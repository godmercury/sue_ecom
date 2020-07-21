<?php
namespace App\Controllers\Admin;

use App\Classes\Request;
use App\Classes\Session;
use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function show()
    {
        Session::add('admin', 'You are welcome, admin user.');
        Session::remove('admin');

        if (Session::has('admin')) {
            $message = Session::get('admin');
        } else {
            $message = 'Not defined.';
        }
        view('admin/dashboard', ['admin'=>$message]);
    }

    public function get()
    {
        echo '<pre>';
        $data = Request::old('post', 'products');
        var_dump($data);

        if (Request::has('post')) {
            $request = Request::get('post');
            var_dump($request);
        } else {
            var_dump('not exist');
        }
    }

}