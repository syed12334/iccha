# SparkPost PHP Curl
Use sparkpost CURL with PHP

# Why
I couldn't be bothered working with SparkPosts PHP composer example and needed something light and modifiable. A simple curl example was not avaialbe in PHP, so one was built and one was shared.

# Requirements
You will need to modifiy your php.ini for points 1 & 2.  Points 3 & 4 are done on SparkPost

1. openssl.cafile value 'openssl.cafile= "ca-bundle.crt"' you can grab a bundle here https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
2. curl must be enabled 'extension=php_curl.dll'
3. A SparkPost API key
4. Validate your domain with SparkPost


#Simple Example
<pre>
include('sparkpost-api.php');

$mail = new sparkPostApi('https://api.sparkpost.com/api/v1/transmissions','< YOUR API KEY >');
$mail-> from(array(
  'email' => 'validated@yourdomain.com',
  'name'  => 'Sender Name'
));

$mail-> subject('My First Sparkpost Mail');
$mail-> html('
	Mandrill is over<br />
	Mandrill is now a paid service, let\'s move to sparkpost!
');
$mail-> setTo(array('person1@yourdomain.com','person2@yourdomain.com'));
$mail-> setReplyTo('youremail@yourdomain.com');

try{
	$mail->send();
	print "Message Sent";
} 
catch (Exception $e) {
	print $e;	
}

$mail->close();
</pre>

#Template Example
<pre>
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
</pre>


