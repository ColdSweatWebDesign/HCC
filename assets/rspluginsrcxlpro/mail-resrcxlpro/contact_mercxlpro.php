<?php
/* Contact XL PHP Processing Script by Steve Riches - RichoSoft Squared - (C) 2017 - All Rights Reserved */
/* August 2017 - www.richosoft2.co.uk */
include 'secret.php';
$sendfrom=explode(',', $_POST['sendto']);
// Set Site Email Addresses Here
/* This email must be one set up on your domain for most hosts and is the email to send mail from */
$siteemailtosend=$sendfrom[0];
/* This email is your email to receive the contact form details and can be the same as the one above if required */
$siteemailtoreceive=$_POST['sendto'];
// ******************************************************************
// DO NOT EDIT ANYTHING BELOW HERE UNLESS YOU KNOW WHAT YOU ARE DOING
// ******************************************************************
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo $_GET["jsoncall"].'{"response":9}';
   return false;
   }
   
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));
$subject = strip_tags(htmlspecialchars($_POST['subject']));
$address1 = strip_tags(htmlspecialchars($_POST['address1']));
$address2 = strip_tags(htmlspecialchars($_POST['address2']));
$city = strip_tags(htmlspecialchars($_POST['city']));
$county = strip_tags(htmlspecialchars($_POST['county']));
$country = strip_tags(htmlspecialchars($_POST['country']));
$postcode = strip_tags(htmlspecialchars($_POST['postcode']));
$mobile = strip_tags(htmlspecialchars($_POST['mobile']));
$company = strip_tags(htmlspecialchars($_POST['company']));
$gender = strip_tags(htmlspecialchars($_POST['gender']));
$copyto=strip_tags(htmlspecialchars($_POST['copyto']));
$websiteurl=strip_tags(htmlspecialchars($_POST['websiteurl']));
$linkedinurl=strip_tags(htmlspecialchars($_POST['linkedinurl']));
$facebookurl=strip_tags(htmlspecialchars($_POST['facebookurl']));
$ipaddress = $_SERVER["REMOTE_ADDR"];   
$response=$_POST["captcha"];
function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
		echo $_GET["jsoncall"].'{"response":5}';
		exit();
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
$verify=url_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$response}");
$captcha_success=json_decode($verify);
if ($captcha_success->success==false) {
echo $_GET["jsoncall"].'{"response":8}';
return false;
}
else if ($captcha_success->success==true) {
// Create the email and send the message
$to = $siteemailtoreceive;
$email_subject = "Website Contact From:  $name";
$email_body = "You have received a new message from your website contact form.\n\r\n";
$email_body = $email_body."Here are the details:\n\r\n";
$email_body = $email_body."Name: $name\n\r\n";
$email_body = $email_body."Email: $email_address\n\r\n";
if($subject!="|na|"){$email_body = $email_body."Subject: $subject\n\r\n";}
$email_body = $email_body."Message:\n$message\n\n\r\n";
$email_body = $email_body."Phone: $phone\n\r\n";
if($mobile!="|na|"){$email_body = $email_body."Mobile/Cell: $mobile\n\r\n";}
if($address1!="|na|"){$email_body = $email_body."Address 1: $address1\r\n";}
if($address2!="|na|"){$email_body = $email_body."Address 2: $address2\r\n";}
if($city!="|na|"){$email_body = $email_body."City/Town: $city\r\n";}
if($county!="|na|"){$email_body = $email_body."County/State/Province: $county\r\n";}
if($country!="|na|"){$email_body = $email_body."Country: $country\r\n";}
if($postcode!="|na|"){$email_body = $email_body."Post Code/Zip: $postcode\n\r\n";}
if($company!="|na|"){$email_body = $email_body."Company: $company\n\r\n";}
if($gender!="|na|"){$email_body = $email_body."Gender: $gender\n\r\n";}
if($websiteurl!="|na|"){$email_body = $email_body."Web Site: $websiteurl\r\n";}
if($facebookurl!="|na|"){$email_body = $email_body."Facebook Page: $facebookurl\r\n";}
if($linkedinurl!="|na|"){$email_body = $email_body."Linked In Page: $linkedinurl\n\r\n";}
$email_body = $email_body."Sender's IP Address: $ipaddress\n\r\n";
$email_body = $email_body."Form on page: ".$_SERVER['HTTP_REFERER']."\n\r\n";
$headers = "From: $siteemailtosend\n";
$headers .= "Reply-To: $email_address\n";
$headers .= "Mime-Version: 1.0\n";
$headers .= "Content-type: text/plain; charset=UTF-8\n";
if(!mail($to,$email_subject,$email_body,$headers)){
echo $_GET["jsoncall"].'{"response":7}';
exit();
}
else
{
if($copyto!="|na|"){
$email_subject = "Copy of your Submission to $copyto on the Website Contact Form";
$email_body = "You submitted data to $copyto on the web site contact form.\n\r\n";
$email_body = $email_body."These are the details you submitted:\n\r\n";
$email_body = $email_body."Name: $name\n\r\n";
$email_body = $email_body."Email: $email_address\n\r\n";
if($subject!="|na|"){$email_body = $email_body."Subject: $subject\n\r\n";}
$email_body = $email_body."Message:\n$message\n\n\r\n";
$email_body = $email_body."Phone: $phone\n\r\n";
if($mobile!="|na|"){$email_body = $email_body."Mobile/Cell: $mobile\n\r\n";}
if($address1!="|na|"){$email_body = $email_body."Address 1: $address1\r\n";}
if($address2!="|na|"){$email_body = $email_body."Address 2: $address2\r\n";}
if($city!="|na|"){$email_body = $email_body."City/Town: $city\r\n";}
if($county!="|na|"){$email_body = $email_body."County/State/Province: $county\r\n";}
if($country!="|na|"){$email_body = $email_body."Country: $country\r\n";}
if($postcode!="|na|"){$email_body = $email_body."Post Code/Zip: $postcode\n\r\n";}
if($company!="|na|"){$email_body = $email_body."Company: $company\n\r\n";}
if($gender!="|na|"){$email_body = $email_body."Gender: $gender\n\r\n";}
if($websiteurl!="|na|"){$email_body = $email_body."Web Site: $websiteurl\r\n";}
if($facebookurl!="|na|"){$email_body = $email_body."Facebook Page: $facebookurl\r\n";}
if($linkedinurl!="|na|"){$email_body = $email_body."Linked In Page: $linkedinurl\n\r\n";}
$email_body = $email_body."Thank you for your submission.\n\r\n";
$email_body = $email_body."The Team at $copyto\n\r\n";
$email_body = $email_body."Your IP Address: $ipaddress\n\r\n";
$email_body = $email_body."Sent from the Form on page: ".$_SERVER['HTTP_REFERER']."\n\r\n";
$headers = "From: $siteemailtosend\n";
$headers .= "Reply-To: $siteemailtosend\n";
$headers .= "Mime-Version: 1.0\n";
$headers .= "Content-type: text/plain; charset=UTF-8\n";	
mail($email_address,$email_subject,$email_body,$headers);
}
	echo $_GET["jsoncall"].'{"response":2}';
return true;       
}
}
?>
