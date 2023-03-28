<?php
	
	include('sparkpost-api.php');
	
	
	$mail = new sparkPostApi('https://api.sparkpost.com/api/v1/transmissions','b6885278b60d261ec6ae75f711df303dd6e7dc02');

	$mail-> from(array('email' => 'info@abhinavinfo.com','name' => 'Sender Name'));
	$mail-> subject('My First Sparkpost Mail');
	$mail-> html('
		<h1>Mandrill is over</h1>
		<p>Mandrill is now a paid service, let\'s move to sparkpost!</p>
	');
	
	$mail-> setTo(array('aruna@savithru.com', 'gvsuresh@savithru.com', 'vanitha@savithru.com'));
	$mail->setReplyTo('info@abhinavinfo.com');
	
	$filePath = $_SERVER['DOCUMENT_ROOT'].'/assets/receiptpdf/';
	$fileName = "School_fee_receipt_NPSKRM19-200001.pdf";
	$fileType = mime_content_type($filePath.$fileName);
	$fileData = base64_encode(file_get_contents($filePath.$fileName));
	$arr = array();
	$arr[] = array('name' => $fileName, 'type' => $fileType, 'data' => $fileData);
	$mail->attachments($arr);
	
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
