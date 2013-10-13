

<?php

$notValid = false;

//Prefedined Variables
$to = "harris@harrisequip.com";
$subject = "E-Newsletter Sign-up!";
$signupSubject = "Thanks for signing up!";

$extras = "From: Harris <harris@harrisequip.com> \r\n";
$extras .= "Content-Type: text/html\n";

if($_POST) {
	// Collect POST data from form
	$email = stripslashes($_POST['email']);
	
	if (!empty($email)) {
		//regex to ensure no illegal characters in email address
		$checkEmail = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
		if (!preg_match($checkEmail, $email)){
			$notValid = true;
		}
	}
	// Define email variables
	$message = "$email\n\n";
	$message .= "Signed up for the Harris E-Newsletter!";

	
	//Confirm message to Signup person
			$replyMessage = "<html>";
			$replyMessage .= "<body>";
			$replyMessage .= "<table cellspacing='0' cellpadding='0' width='650' style='font-family:sans-serif;'>";
			$replyMessage .= "<tr>";
			$replyMessage .= "<td>";
			$replyMessage .= "<table cellpadding='0' cellspacing='0' width='650'>";
			$replyMessage .= "<tr style='background-color:#ccc; padding-top:5px;'>";
			$replyMessage .= "<td style='padding:10px 0 10px 20px' width='100'><img src='http://www.harrisequip.com/wp-content/images/HarrisLogo_small.png'</td>";
			$replyMessage .= "<td style='font-family:sans-serif; font-weight:bold; font-size:22px; color:#444;  padding:5px 0 0 10px;' valign='middle'>eNewsletter Signup</td>";
			$replyMessage .= "</tr></table></td></tr><tr>";
			$replyMessage .= "<table cellpadding='0' cellspacing='0' width='650' style='font-family:sans-serif;' >";
			$replyMessage .= "<tr style=''>";
			$replyMessage .= "<td style='padding:25px 0 20px 20px; font-size:24px;'><strong>Thanks</strong> $email!</td>";
			$replyMessage .= "</tr><tr>";
			$replyMessage .= "<td style='padding:0 0 20px 20px'><p style='line-height:20px;'>You have signed up for the Harris eNewsletter. We are happy that you decided to follow Harris News and notes. You will be the first to know of new products or developments about Harris and our products. </p>";
			$replyMessage .= "<p style='line-height:20px;'>If you are a social networking person please follow us on <a href='' style='color:#dc291e;'>Twitter</a> or on <a href='' style='color:#dc291e;'>Facebook</a>.</p>";
			$replyMessage .= "</td></tr><tr>";
			$replyMessage .= "<td style='padding:30px 0 10px 20px'><p>If you would like to remove yourself from future emails go to <a href='http://www.harrisequip.com/unsubscribe' style='color:#dc291e;'>www.harrisequip.com/unsubscribe</a></p>";
			$replyMessage .= "</td></tr></table></tr><tr><td>";
			$replyMessage .= "<table cellpadding='0' cellspacing='0' width='650'>";
			$replyMessage .= "<tr style='background-color:#ccc; padding-top:5px;'>";
			$replyMessage .= "<td style='font-family:sans-serif; font-size:11px; color:#444;  padding:5px 0 5px 10px;' valign='middle'>&copy; Harris Waste Management Group, Inc. 215 Market Rd. Suite 1A Tyrone, GA 30290</td>";
			$replyMessage .= "</tr></table></td></tr></table>";
			$replyMessage .= "</body>";
			$replyMessage .= "</html>";

	//Validate
	//$header_injections = preg_match("(\r|\n)(to:|from:|cc:|bcc:)", $comment);

	if( !empty($email) && !$notValid ) {
		//send signup message
		$mailSent = mail($to, $subject, $message);
		//send confirm message
		$signupMessage = mail($email, $signupSubject, $replyMessage, $extras);
		
		if ($mailSent && $signupMessage) {
		
		print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.harrisequip.com?signupComplete=yes\">";
		
		} else { 
			echo "Nothing was sent";
		
		}
		
	} else {
		print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.harrisequip.com?signupComplete=no\">";
		exit();
	}
}

?>

