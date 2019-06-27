<?php
require "phpMailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

define('USERNAME', 'amarjyoti.gautam@gmail.com');				
define('PASSWORD', 'amar25@#');
define('API_KEY', 'YIb8SdUTJV1OeGc2nwDuxH3jMthWygl7CQkBXA9KqN6F45LrRi2baO7Vn1ZcY3K5lhTAgSF09ktjHfrs');


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

	public static function sendSMS($text, $numbers)
	{
		$fields = array(
		    "sender_id" => "FSTSMS",
		    "message" => $text,
		    "language" => "english",
		    "route" => "p",
		    "numbers" => $numbers,						// multiple numbers can be added as CSV
		);



		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_SSL_VERIFYHOST => 0,
		  CURLOPT_SSL_VERIFYPEER => 0,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($fields),
		  CURLOPT_HTTPHEADER => array(
		    "authorization: " . API_KEY,
		    "accept: */*",
		    "cache-control: no-cache",
		    "content-type: application/json"
		  ),

		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return "SMS could not be sent. Error: " . $err;
		}
		else {
			$arr = json_decode($response, true);
			return $arr['message'][0];
		}
	}
}