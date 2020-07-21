<?php

require_once __DIR__ . '/../bootstrap/init.php';

$app_name = getenv('APP_NAME');

use \Illuminate\Database\Capsule\Manager as Capsule;

//$user = \Illuminate\Database\Capsule\Manager::table('users')->where('id',1)->first();
//$user = Capsule::table('users')->where('id', 1)->first();

//var_dump($user);