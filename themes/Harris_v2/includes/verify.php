<?php

if(isset($_POST['emailSubmit'])) {

$mailTo = 'harris@harrisequip.com';
$email = $_POST['email'];
$subject = 'Harris E-Newsletter Signup!';

	if($_POST['email'] == '') {
		$emailToError = 'You forgot to enter the email address to send to.';
		echo $emailToError;
	} 
	if (!empty($email)) {
		//regex to ensure no illegal characters in email address
		$checkEmail = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
		if (!preg_match($checkEmail, $email)){
			$emailToError = 'Please enter a valid email address.';
		}
	}
	if (!isset($emailToError)) {
		//build the message
		$message = "$email\n\n";
		$message .= "Signed up for the Harris E-Newsletter!";
		
		//create a word-wrap, limit to 70 characters
		$message = wordwrap($message, 70);

			
		$mailSent = mail($mailTo, $subject, $message);
	
		if ($mailSent) {
			header('Location: http://localhost:8888/Harris2011?signupComplete=yes');
			exit();
		} else { 
			echo "Nothing was sent";
		
		}
	
	} else {
	
		echo "Email Error!";
	
	}
	
	}
	

	

<?php echo $emailToError; ?>