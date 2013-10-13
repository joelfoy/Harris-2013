<?php
function validateEmail($email)
{  
	return ereg("^[a-zA-Z0-9]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$", $email);  
}
    
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
/*******************************
********************************/
	error_reporting(0);
	//create error array
	$errors = array();

	//test inputs
	if (!$_POST['name'])
		$errors[] = "Name is required";
	if (!$_POST['company'])
		$errors[] = "Company is required";
	if (!$_POST['email'])
		$errors[] = "A valid email is required";
	if (!validateEmail($_POST['email']))
		$errors[] = "A valid email is required";
	if (!$_POST['phone'])
		$errors[] = "Phone Number is required";
	if (!$_POST['address'])
		$errors[] = "An address is required";
	if (!$_POST['city'])
		$errors[] = "A city is required";
	if (!$_POST['state'])
		$errors[] = "A state is required";
	if (!$_POST['zip'])
		$errors[] = "A zipcode is required";
	if ($_POST['country'] == "Please Choose")
		$errors[] = "Please select a country";
	if ($_POST['machine'] == "Pick your machine")
		$errors[] = "Please select a machine";
	if ($_POST['source'] == "Please Choose")
		$errors[] = "Please select how you found Harris";
	if ($_POST['formcomments'] == "")
		$errors[] = "What are you looking for?";
	
	//if ERRORS ->
	if (count($errors) > 0) {
	print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.harrisequip.com/sales/machine-information?requestComplete=no\">";
	} else {
	
		//no errors
		//values
		$subject = "Harris Machine Info Request Form";
		$to ="harris@harrisequip.com";
		$name = $_POST['name'];
		$company = $_POST['company'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$country = $_POST['country'];
		$machine = $_POST['machine'];
		$source = $_POST['source'];
		$comments = stripslashes($_POST['formcomments']);
		
		//values for reply mail
		$replyTo = ($_POST['email']);
		$replySubject = "Harris Machine Info Request";
		$extras = "From: Harris <harris@harrisequip.com> \r\n";
		$extras .= "Content-Type: text/html\n";
		
		//build message
		$message = "Name: $name\n\n";
		$message .= "Company: $company\n\n";
		$message .= "Email: $email\n\n";
		$message .= "Phone: $phone\n\n";
		$message .= "Address: $address\n\n";
		$message .= "City: $city\n\n";
		$message .= "State: $state\n\n";
		$message .= "Zipcode: $zip\n\n";
		$message .= "Country: $country\n\n";
		$message .= "Machine interest: $machine\n\n";
		$message .= "Found Harris through: $source\n\n";
		$message .= "Comments: \n\n $comments";
		
		//Build Reply Message
			$replyMessage = "<html>";
			$replyMessage .= "<body>";
			$replyMessage .= "<table cellspacing='0' cellpadding='0' width='650' style='font-family:sans-serif;'>";
			$replyMessage .= "<tr>";
			$replyMessage .= "<td>";
			$replyMessage .= "<table cellpadding='0' cellspacing='0' width='650'>";
			$replyMessage .= "<tr style='background-color:#ccc; padding-top:5px;'>";
			$replyMessage .= "<td style='padding:10px 0 10px 20px' width='100'><img src='http://www.harrisequip.com/wp-content/images/HarrisLogo_small.png'</td>";
			$replyMessage .= "<td style='font-family:sans-serif; font-weight:bold; font-size:22px; color:#444;  padding:5px 0 0 10px;' valign='middle'>Contact Form</td>";
			$replyMessage .= "</tr></table></td></tr><tr>";
			$replyMessage .= "<table cellpadding='0' cellspacing='0' width='650' style='font-family:sans-serif;' >";
			$replyMessage .= "<tr style=''>";
			$replyMessage .= "<td style='padding:25px 0 20px 20px; font-size:24px;'><strong>Thanks</strong> $name!</td>";
			$replyMessage .= "</tr><tr>";
			$replyMessage .= "<td style='padding:0 0 20px 20px'><p style='line-height:20px;'>Thank you for contacting Harris. We take every message seriously and know that your time is important. A harris representative will contact you as soon as possible. </p>";
			$replyMessage .= "<p style='line-height:20px;'>Please feel free to call Harris at 800.373.9131 or 770.631.7290 if you would like to speak with someone immediately.</p>";
			$replyMessage .= "</td></tr><tr>";
			$replyMessage .= "<td style='padding:0 0 10px 20px'><p>From the form you filled out we know you are looking for information on a Harris $machine.</p>";
			$replyMessage .= "<p>If there is any other information you think would be important please let the Harris representative know.</p>";
			$replyMessage .= "<p style='font-size:20px;'>Thank you</p>";
			$replyMessage .= "</td></tr></table></tr><tr><td>";
			$replyMessage .= "<table cellpadding='0' cellspacing='0' width='650'>";
			$replyMessage .= "<tr style='background-color:#ccc; padding-top:5px;'>";
			$replyMessage .= "<td style='font-family:sans-serif; font-size:11px; color:#444;  padding:5px 0 5px 10px;' valign='middle'>&copy; Harris Waste Management Group, Inc. 215 Market Rd. Suite 1A Tyrone, GA 30290</td>";
			$replyMessage .= "</tr></table></td></tr></table>";
			$replyMessage .= "</body>";
			$replyMessage .= "</html>";
		
		//SEND REPLY-EMAIL
		$contactReplyMessage = mail($replyTo, $replySubject, $replyMessage, $extras);
		
		if ($contactReplyMessage) {	
		//SEND EMAIL	
		$mailSent = mail($to, $subject, $message);
		} else	{
			echo "Your form is broken.";
		}
		
		if ($mailSent) {
			print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.harrisequip.com/sales/machine-information?requestComplete=yes\">";
		} else { 
			print "<meta http-equiv=\"refresh\" content=\"0;URL=http://www.harrisequip.com/sales/machine-information?requestComplete=error\">";
			exit();
		}
		
	}
	if($mailSent) {
		//START HubSpot Lead Submission
		$strPost = "";
		//create string with form POST data
		$strPost = "FullName=" . urlencode($_POST['name'])
		. "&Email=" . urlencode($_POST['email'])
		. "&TwitterHandle=" . urlencode($_POST['twitter_handle'])
		. "&Phone=" . urlencode($_POST['phone']) 
		. "&Fax=" . urlencode($_POST['fax_number'])
		. "&Website=" . urlencode($_POST['website'])
		. "&Company=" . urlencode($_POST['company'])
		. "&JobTitle=" . urlencode($_POST['job_title']) 
		. "&Address=" . urlencode($_POST['address']) 
		. "&City=" . urlencode($_POST['city']) 
		. "&State=" . urlencode($_POST['state'])
		. "&ZipCode=" . urlencode($_POST['zip']) 
		. "&Country=" . urlencode($_POST['country']) 
		. "&Message=" . urlencode($_POST['formcomments'])
		. "&Machine=" . urlencode($_POST['machine'])
		. "&NumberEmployees=" . urlencode($_POST['num_employees']) 
		. "&AnnualRevenue=" . urlencode($_POST['annual_revenue']) 
		. "&CloseDate=" . urlencode($_POST['close_date']) 
		. "&IPAddress=" . urlencode($_SERVER['REMOTE_ADDR']) 
		. "&UserToken=" . urlencode($_COOKIE['hubspotutk']);
		//set POST URL
		$url = "http://harrisequip.app5.hubspot.com/?app=leaddirector&FormName=Machine+Info+Request";
		//intialize cURL and send POST data
		$ch = @curl_init();
		@curl_setopt($ch, CURLOPT_POST, true);
		@curl_setopt($ch, CURLOPT_POSTFIELDS, $strPost);
		@curl_setopt($ch, CURLOPT_URL, $url);
		@curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		@curl_exec($ch);
		@curl_close($ch);
		//END HubSpot Lead Submission
		
	} else { ?>
		<h1>You have encountered an error!</h1>
	<?php }	
} else { ?>
<h1>You do not have access</h1>
<?php }	
?>
<!-- Google Code for Machine Info Form Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1026911858;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "5RW5CJbUlQIQ8tzV6QM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1026911858/?label=5RW5CJbUlQIQ8tzV6QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>