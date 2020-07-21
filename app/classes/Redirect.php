<?php
namespace App\Classes;


class Redirect
{
    /**
     * Redirect to specific page
     *
     * @param $page
     */
    public static function to($page)
    {
        header('location:' . $page);
    }

    /**
     * Recirect to same page
     */
    public static function back()
    {
        $uri = $_SESSION['REQUEST_URI'];
        header('location:' . $uri);
    }
}