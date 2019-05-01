<?php
require "phpMailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('USERNAME', 'amarjyoti.gautam@gmail.com');				
define('PASSWORD', 'amar25@#');

class MyUtil
{
	public static function sendEmail($to, $from, $subject, $body)
	{
			$mail = new PHPMailer();

				//Server settings
				// $mail->SMTPDebug = 2;
		    $mail->isSMTP();                                     	 	// Set mailer to use SMTP
		    $mail->Host = 'smtp.gmail.com';  							// Specify  SMTP servers
		    $mail->SMTPAuth = true;                               		// Enable SMTP authentication
		    $mail->Username = USERNAME;                 				// SMTP username
		    $mail->Password = PASSWORD;                   				// SMTP password
		    $mail->SMTPSecure = 'tls';                            		// Enable TLS encryption
		    $mail->Port = 587;                                    		// TCP port to connect to

		    //Recipients
		    $mail->setFrom($from, 'Amarjyoti Gautam');
		    // Add a recipient
		    $mail->addAddress($to);


		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    // send email
		    if ($mail->send()) {
				echo 'Email has been sent';
		    }
			else {
				echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
		    }

	}
}