<?php
namespace App\classes;


class CSRFToken
{
    /**
     * Generate Token
     *
     * @return mixed
     */
    public static function _token()
    {
        // Session::remove('token'); exit;
        if (!Session::has('token')) {
            $randomToken = base64_encode(openssl_random_pseudo_bytes(32));
            Session::add('token', $randomToken);
        }
        return Session::get('token');
    }

    /**
     * Verify CSRF TOKEN
     *
     * @param $requestToken
     * @return bool
     */
    public static function verifyCSRFToken($requestToken)
    {
        if (Session::has('token') && Session::get('token') === $requestToken) {
            Session::remove('token');
            return true;
        }
        return false;
    }


}