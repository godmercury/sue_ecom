<?php
namespace App\Classes;

class ErrorHandler
{

    /**
     * Error Message Handle
     *
     * @param $error_number
     * @param $error_message
     * @param $error_file
     * @param $error_line
     */
    public function handleErrors($error_number, $error_message, $error_file, $error_line)
    {
        $error = '[' . $error_number . '] An error occurred in file "' . $error_file . '" on line ' . $error_line . ' : ' . $error_message;
        $environment = getenv('APP_ENV');

        if ($environment === 'local') {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        } else {
            $data = [
                'to' => getenv('ADMIN_EMAIL'),
                'subject' => 'System Error',
                'view' => 'errors',
                'name' => 'Admin',
                'body' => $error
            ];

            ErrorHandler::emailAdmin($data)->outputFrendlyError();
        }
    }

    /**
     * Make Error Mail
     */
    public function outputFrendlyError()
    {
        ob_end_clean();
        view('errors/generic');
        exit();
    }

    /**
     * Send mail error message
     *
     * @param $data
     * @return static
     */
    public static function emailAdmin($data)
    {
        $mail = new Mail();
        $mail->send($data);

        return new static();
    }

}