<?php
use Slim\App;

class helpers
{
    public static function jsonResponse($app, $data = array(), $status = 200, $message = '')
    {
        $rsp          = new stdClass();
        $rsp->message = $message;
        $rsp->data    = $data;
        
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->headers->set('Access-Control-Allow-Origin', '*');
        $app->response->headers->set('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
        $app->response->headers->set('Access-Control-Allow-Headers', 'X-CSRF-Token, X-Requested-With, Accept, Accept-Version, Content-Length, Content-MD5, Content-Type, Date, X-Api-Version');
        $app->response->setStatus($status);
        $app->response->setBody(str_replace("\u0000",0,str_replace("\u0001",1,json_encode($rsp))));
    }

      private function EnviaEmail($mail_msg)
    {
        try {
            $filename = $mail_msg->getdoc();
            $mail = new PHPMailer;
            $mail->setLanguage('pt-br', 'vendor/phpmailer/phpmailer/language/');
            //$mail->SMTPDebug = 3;                               	// Enable verbose debug output
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();										// Set mailer to use SMTP
            $mail->Host = '';										// Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               	// Enable SMTP authentication
            $mail->Username = '';                 					// SMTP username
            $mail->Password = '';                           		// SMTP password
            //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    	// TCP port to connect to
            $mail->setFrom($mail->Username);
            $mail->addAddress('');     								// Add a recipient
            //$mail->addCC('c@example.com');
            $mail->isHTML(true);                                  	// Set email format to HTML
            $mail->Subject = "";
            $mail->AltBody = "";
            $mail->Body = $mail->AltBody;
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
