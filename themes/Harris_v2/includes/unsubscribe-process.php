

<?php

$notValid = false;

//Prefedined Variables
$to = "harris@harrisequip.com";
$subject = "E-Newsletter Removal";
$signupSubject = "Sorry to see you go";

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
	$message .= "remove from the Harris E-Newsletter";

	
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
			$replyMessage .= "<td style='padding:25px 0 20px 20px; font-size:24px;'><strong>Sorry to see you go</strong> $email!</td>";
			$replyMessage .= "</tr><tr>";
			$replyMessage .= "<td style='padding:0 0 20px 20px'><p style='line-height:20px;'>We are sorry you have decided to cancel your subscription to the Harris e-newsletter.</p>";
			$replyMessage .= "<p style='line-height:20px;'>Your email is being deleted from our list and you will no longer receive emails from Harris. If you did this on accident or want to resubscribe please fill out the subscription form on our homepage.</p>";
			$replyMessage .= "</td></tr><tr>";
			$replyMessage .= "</tr></table></tr><tr><td>";
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
		
		
		print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.harrisequip.com/unsubscribe?unsubscribeComplete=yes\">";
		
		} else { 
			echo "Nothing was sent";
		
		}
		
	} else {
		print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.harrisequip.com/unsubscribe?unsubscribeComplete=no\">";
		exit();
	}
}

?>

