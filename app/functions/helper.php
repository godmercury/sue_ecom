<?php

use Philo\Blade\Blade;

function view($path, array $data = [])
{
    $view = __DIR__ . '/../../resources/views';
    $cache = __DIR__ . '/../../bootstrap/cache';
    $blade = new Blade($view, $cache);

    echo $blade->view()->make($path, $data)->render();
}

function make($filename, $data)
{
    /*
    $data = [
        'to' => 'test@test.com',
        'subject' => 'Welcome to Sue Store ',
        'view' => 'welcome',
        'name' => 'Sue',
        'body' => 'TEsting email template'
    ];
    */

    extract($data);
    // turn on output buffering
    ob_start();
    // include template
    include(__DIR__ . '/../../resources/views/emails/' . $filename . '.php');
    // get content of the file
    $content = ob_get_contents();
    // erase the output and turn off output buffering
    ob_end_clean();

    return $content;
}

function slug($value)
{
    // remove all characters not in this list : underscore | letters | numbers | whitespace
    $value = preg_replace('![^' . preg_quote('_') . '\pL\pN\s]+!u','', mb_strtolower($value));

    // remove underscore  with a dash -
    $value = preg_replace('![' . preg_quote('-') . '\s]+!u','-', $value);

    // remove whitespace
    return trim($value, '-');
}