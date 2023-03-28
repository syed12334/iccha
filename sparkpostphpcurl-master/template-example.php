<?php
	
	include('sparkpost-api.php');
	
	
	$mail = new sparkPostApi('https://api.sparkpost.com/api/v1/transmissions','<YOUR API KEY>');

	$mail-> from(array('email' => 'validated@yourdomain.com','name' => 'Sender Name'));
	$mail-> subject('My First Sparkpost Mail');
	
	/*========================================================================
	// TEMPLATE USAGE
	// $mail->template(template_id (String)>,Substitution Data (Array));
	/=======================================================================*/
	
	$mail-> template(
		'my-first-email',
		array(
			'Name'    => 'John Doe',
			'Message' => '
				Mandrill is now a paid service, let\'s move to sparkpost!
			'
		)
	);

	$mail-> setTo(array('person1@yourdomain.com','person2@yourdomain.com'));
	$mail->setReplyTo('youremail@yourdomain.com');
	
	/* CC emails as array same as "seTo"
	//$mail->setCc(array('person1@yourdomain.com','person2@yourdomain.com'));

	/* BCC emails as array same as "seTo" */
	//$mail->setBcc(array('person1@yourdomain.com','person2@yourdomain.com'));
	
	try{
		$mail->send();
		print "Message Sent";
	} 
	catch (Exception $e) {
		print $e;	
	}


	$mail->close();

?>
