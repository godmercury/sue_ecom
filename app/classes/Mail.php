<?php
namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    protected $mail;

    /**
     * Mail constructor.
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);  // Passing `true` enables exceptions
        $this->setUp();
    }

    /**
     * Mail Environment Setting
     *
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function setUp()
    {
        // Server setting
        $environment = getenv('APP_ENV');

        if ($environment === 'local') {
            $this->mail->SMTPDebug = 2;                     // Enable verbose debug output
        }

        $this->mail->isSMTP();                              // Set mailer to use SMTP
        $this->mail->SMTPAuth = true;                       // Enable SMTP authentication
        $this->mail->SMTPSecure = 'tls';                    // Enable TLS encryption, `ssl` also accepted
        $this->mail->Host = getenv('SMTP_HOST');            // Specify main and backup SMTP servers
        $this->mail->Port = getenv('SMTP_PORT');            // TCP port to connect to
        $this->mail->Username = getenv('EMAIL_USERNAME');   // SMTP username
        $this->mail->Password = getenv('EMAIL_PASSWORD');   // SMTP password

        // Recipients
        $this->mail->setFrom(getenv('ADMIN_EMAIL'), 'sue Store');

        $this->mail->isHTML(true);
        $this->mail->SingleTo = true;
    }

    /**
     * Send Mail
     *
     * @param $data
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send($data) {
        $this->mail->addAddress($data['to'], $data['name']);
        $this->mail->Subject = $data['subject'];
        $this->mail->Body = make($data['view'], array('data' => $data['body']));
        return $this->mail->send();
    }
}