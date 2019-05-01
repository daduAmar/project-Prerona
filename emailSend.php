<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "MyUtil.php";

  $name = "amar";
  $email = "bharatidadu47@gmail.com";
  
 

	// send email
	// make sure Antivirus is turned off
	$subject = "Prerona Project Email Testing";
	$body  = "Hey, <strong>$name</strong><br>"
			. "Are you there!<br>";

	$emailResponse = MyUtil::sendEmail($email, 'amarjyoti.gautam@gmail.com', $subject, $body);


	//return json response back to client
	echo json_encode(array(
		'email-response' => $emailResponse
  ));