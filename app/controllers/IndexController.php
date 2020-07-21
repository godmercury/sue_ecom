<?php
namespace App\Controllers;

use App\Classes\Mail;

class IndexController extends BaseController
{
    public function show()
    {
        echo 'Inside Homepage from controller class';

        $mail = new Mail();

        $data = [
            'to' => 'test@test.com',
            'subject' => 'Welcome to Sue Store ',
            'view' => 'welcome',
            'name' => 'Sue',
            'body' => 'TEsting email template'
        ];

/*
        if ($mail->send($data)) {
            echo 'success';
        } else {
            echo 'fail';
        }
*/



    }
}
