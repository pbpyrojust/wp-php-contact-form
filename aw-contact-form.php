<?php
/*
Plugin Name: AW Contact Form
Plugin URI: http://anthroware.com
Description: An insurance policy contact form for you. Usage: <code>[aw_contact email="your@email.address"]</code>
Version: 1.0
Author: Justin Adams
Author URI: http://justwhat.net
*/
 
function aw_contact_get_the_ip() {
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    else {
        return $_SERVER["REMOTE_ADDR"];
    }
}

function aw_contact_form_sc( $atts ) {
 
    extract( shortcode_atts( array(
    // if you don't provide an e-mail address, the shortcode will pick the e-mail address of the admin:
    "email" => get_bloginfo( 'admin_email' ),
    "label_first_name" => "First Name",
    "label_middle_name" => "Middle Name",
    "label_last_name" => "Last Name",
    "label_gender" => "Gender",
    "label_state" => "What State Do You Live In?",
    "label_month" => "Date of Birth",
    "label_day" => "",
    "label_year" => "",
    "label_feet" => "What Is Your Height?",
    "label_weight" => "What is Your Weight?",
    "label_tobacco" => "Have You Used Tobacco?",
    "label_policy_amount" => "Insurance Policy Amount?",
    "label_how_many_years" => "For How Many Years?",
    "label_email" => "Email Address",
    "label_re_email" => "Re-Enter Email Address",
    "label_phone" => "Phone Number",
    "label_subject" => "Subject",
    "label_message" => "Your Message",
    "label_submit" => "Submit",
    "tp_first" => "Term Price",
    "tp_last" => "Quote",
    "tp_email" => "contact@termpricequote.com",
    "tp_subject" => "Your video life quote request has been received",
    // the error message when at least one of the required fields are empty:
    "error_empty" => "Please fill in all the required fields.",
    // the error message when the e-mail address is not valid:
    "error_noemail" => "Please enter a valid e-mail address.",
    // and the success message when the e-mail is sent:
    "success" => '<style>#successMessage { margin: 0 auto; width: 672px; text-align: center; color: #414141; } #successMessage img { margin-top: 60px; margin-bottom: 34px; } #successMessage strong { display: block; font-size: 25px; } #successMessage p { margin-top: 42px; margin-bottom: 60px; } #successMessage p, #successMessage p strong { font-size: 17px; } #successMessage p strong { display: inline; }</style> <div id="successMessage"><img src="/wp-content/plugins/aw-contact-form/img/icon-thumbs-up.png" alt="Thumbs Up Icon"><strong>REQUEST SUBMITTED</strong><p>THANK YOU FOR CHOOSING <strong>TERMPRICEQUOTE.COM…</strong> <i>LIFE MADE EASY</i>™
WE ARE RESEARCHING THE BEST RATES FOR YOU AND YOU WILL RECEIVE YOUR VIDEO QUOTE WITHIN THE NEXT 24 HOURS.</p></div>'
), $atts ) );

// if the <form> element is POSTed, run the following code
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    $error = false;
    // set the "required fields" to check
    $required_fields = array( "first_name" );
 
    // this part fetches everything that has been POSTed, sanitizes them and lets us use them as $form_data['subject']
    foreach ( $_POST as $field => $value ) {
        if ( get_magic_quotes_gpc() ) {
            $value = stripslashes( $value );
        }
        $form_data[$field] = strip_tags( $value );
    }
 
    // if the required fields are empty, switch $error to TRUE and set the result text to the shortcode attribute named 'error_empty'
    foreach ( $required_fields as $required_field ) {
        $value = trim( $form_data[$required_field] );
        if ( empty( $value ) ) {
            $error = true;
            $result = $error_empty;
        }
    }
 
    // and if the e-mail is not valid, switch $error to TRUE and set the result text to the shortcode attribute named 'error_noemail'
    //if ( ! is_email( $form_data['email'] ) ) {
    //    $error = true;
    //    $result = $error_noemail;
    //}
 
    if ( $error == false ) {
        $subject = "[" . get_bloginfo( 'name' ) . "] " . $form_data['subject'] . "From " . $form_data['first_name'] . " " . $form_data['middle_name'] . " " . $form_data['last_name'];
        $message = "First Name: " . $form_data['first_name'] . "\nMiddle Name: " . $form_data['middle_name'] . "\nLast Name: " . $form_data['last_name'] . "\nGender: " . $form_data['gender'] . "\nState: " . $form_data['states'] . "\nBirth Month: " . $form_data['birth_month'] . "\nBirth Day: " . $form_data['birth_day'] . "\nBirth Year: " . $form_data['birth_year'] . "\nHeight in Feet: " . $_POST['feet'] . "\nHeight in Inches: " . $_POST['inches'] . "\nWeight in LBS: " . $form_data['weight'] . "\nTobacco use: " . $_POST['tobacco'] . "\nPolicy amount: " . $_POST['policyAmount'] . "\nYears?: " . $_POST['howManyYears'] . "\nEmail address: " . $form_data['email'] . "\nPhone Number: " . $form_data['phone'] . "\nIP: " . aw_contact_get_the_ip();
        $headers  = "From: " . $form_data['first_name'] . " " . $form_data['last_name'] . " <" . $form_data['email'] . ">\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
        $headers .= "Content-Transfer-Encoding: 8bit\n";
        wp_mail( $email, $subject, $message, $headers );
        $sent = true;
    }
    if ( $sent == true ) {
        $to = $form_data['email'];
        $subject = $tp_subject;
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>request varification</title>
<style type="text/css">
.tpq {
	color: #FFFFFF;
	font-family: "Open Sans";
	font-size: 24px;
	font-weight: bolder;
}
.regular {
	font-family: "Open Sans";
	font-size: 14px;
	font-weight: normal;
	color: #666666;
	white-space: normal;
	line-height: 28px;
}
.legal {
	font-family: "Open Sans";
	font-size: 10px;
	font-weight: normal;
	color: #999999;
}
.firstline {
	font-size: 18px;
	font-family: "Open Sans";
	font-weight: bold;
	color: #333;
}
.line {
	color: #CCCCCC;
	line-height: normal;
}
hr.style-three {
    border: 0;
    border-bottom: 1px dashed #CCCCCC;
    background: #999999;
	 margin-top:5px;
    margin-bottom:50px;
}
</style>
</head>
<body>
<table width="640" border="0" align="center" cellpadding="20" cellspacing="0">
  <tr align="center">
    <td class="tpq"><img src="http://tpq.reapcrtv.com/wp-content/uploads/2014/08/tpq_fullColor.png" width="343" height="48" /></td>
  </tr>
  <tr align="center">
    <td><h2 class="firstline">Thank you for choosing TermPriceQuote!</h2></td>
  </tr>
  <tr align="center">
    <td align="left"><p class="regular">Hi '. $form_data['first_name']. ',</p>
      <p class="regular">Your personalized life insurance quotes are being researched from highly rated term life insurance carriers. You will receive your video quote within the next 24 hours.</p>
      <ul>
        <li class="regular">Shop the leading insurance carriers</li>
        <li class="regular">Compare your best options.</li>
        <li class="regular">Save time and money.</li>
      </ul>
      <p class="regular">If you have any questions in the meantime, please do not hesitate to call me.<br />
1-866-573-0001 or <a href="mailto:contact@termpricequote.com">contact@termpricequote.com</a></p>
      <p class="regular">Thanks so much, <br />
    Michael D. Lopez, CRIS, LUTCF</p></td>
  </tr>
  <tr align="center">
    <td><hr class="style-three"/>
      <p class="legal">Powered by Vbop™<br />
      Copyright 2014 Vbop, All rights reserved<br />
    California License # 0690603</p></td>
  </tr>
</table>
</body>
</html>';
        $headers  = "From: " . $tp_first . " " . $tp_last . " <" . $tp_email . ">\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\n";
        $headers .= "Content-Transfer-Encoding: 8bit\n";
        wp_mail( $to, $subject, $message, $headers );
        $result = $success;
    }
}

// if there's no $result text (meaning there's no error or success, meaning the user just opened the page and did nothing) there's no need to show the $info variable
if ( $result != "" ) {
    $info = '<div>' . $result . '</div>';
}

function genderList() {
	$gender = array('M'=>"Male",'F'=>"Female",);
	return $gender;
}
$gender = genderList();

// states array for dropdown
function statesList() {
	$states = array('AL'=>"Alabama",
					'AK'=>"Alaska",
					'AZ'=>"Arizona",
					'AR'=>"Arkansas",
					'CA'=>"California",
					'CO'=>"Colorado",
					'CT'=>"Connecticut",
					'DE'=>"Delaware",
					'DC'=>"District Of Columbia",
					'FL'=>"Florida",
					'GA'=>"Georgia",
					'HI'=>"Hawaii",
					'ID'=>"Idaho",
					'IL'=>"Illinois",
					'IN'=>"Indiana",
					'IA'=>"Iowa",
					'KS'=>"Kansas",
					'KY'=>"Kentucky",
					'LA'=>"Louisiana",
					'ME'=>"Maine",
					'MD'=>"Maryland",
					'MA'=>"Massachusetts",
					'MI'=>"Michigan",
					'MN'=>"Minnesota",
					'MS'=>"Mississippi",
					'MO'=>"Missouri",
					'MT'=>"Montana",
					'NE'=>"Nebraska",
					'NV'=>"Nevada",
					'NH'=>"New Hampshire",
					'NJ'=>"New Jersey",
					'NM'=>"New Mexico",
					'NY'=>"New York",
					'NC'=>"North Carolina",
					'ND'=>"North Dakota",
					'OH'=>"Ohio",
					'OK'=>"Oklahoma",
					'OR'=>"Oregon",
					'PA'=>"Pennsylvania",
					'RI'=>"Rhode Island",
					'SC'=>"South Carolina",
					'SD'=>"South Dakota",
					'TN'=>"Tennessee",
					'TX'=>"Texas",
					'UT'=>"Utah",
					'VT'=>"Vermont",
					'VA'=>"Virginia",
					'WA'=>"Washington",
					'WV'=>"West Virginia",
					'WI'=>"Wisconsin",
					'WY'=>"Wyoming");
	return $states;
}
$states = statesList();

// feet array for dropdown
function feetList() {
	$feet = array('3'=>"3",
  '4'=>"4",
  '5'=>"5",
  '6'=>"6",
  '7'=>"7");
  return $feet;
}
$feet = feetList();

// inches array for dropdown
function inchesList() {
	$inches = array('0'=>"0",
	'1'=>"1",
	'2'=>"2",
	'3'=>"3",
	'4'=>"4",
	'5'=>"5",
	'6'=>"6",
	'7'=>"7", 
	'8'=>"8",
	'9'=>"9",
	'10'=>"10",
	'11'=>"11",
	'12'=>"12"); 
	return $inches;
}
$inches = inchesList();

// tobacco array for dropdown
function tobaccoList() {
	$tobacco = array('Never Used'=>"Never Used",
	'Now Using'=>"Now Using",
	'Stopped Using'=>"Stopped Using");
	return $tobacco;
}
$tobacco = tobaccoList();

// polocy amount array for dropdown
function policyAmountList() {
	$policyAmount = array('$100,000'=>"$100,000",
	'$150,000'=>"$150,000",
	'$200,000'=>"$200,000",
	'$250,000'=>"$250,000",
	'$300,000'=>"$300,000",
	'$350,000'=>"$350,000",
	'$400,000'=>"$400,000",
	'$450,000'=>"$450,000",
	'$500,000'=>"$500,000",
	'$550,000'=>"$550,000",
	'$600,000'=>"$600,000",
	'$650,000'=>"$650,000",
	'$700,000'=>"$700,000",
	'$750,000'=>"$750,000",
	'$800,000'=>"$800,000",
	'$850,000'=>"$850,000",
	'$900,000'=>"$900,000",
	'$950,000'=>"$950,000",
	'$1,000,000'=>"$1,000,000",
	'$1,050,000'=>"$1,050,000",
	'$1,100,000'=>"$1,100,000",
	'$1,150,000'=>"$1,150,000",
	'$1,200,000'=>"$1,200,000",
	'$1,250,000'=>"$1,250,000",
	'$1,300,000'=>"$1,300,000",
	'$1,350,000'=>"$1,350,000",
	'$1,400,000'=>"$1,400,000",
	'$1,450,000'=>"$1,450,000",
	'$1,500,000'=>"$1,500,000",
	'$1,550,000'=>"$1,550,000",
	'$1,600,000'=>"$1,600,000",
	'$1,650,000'=>"$1,650,000",
	'$1,700,000'=>"$1,700,000",
	'$1,750,000'=>"$1,750,000",
	'$1,800,000'=>"$1,800,000",
	'$1,850,000'=>"$1,850,000",
	'$1,900,000'=>"$1,900,000",
	'$1,950,000'=>"$1,950,000",
	'$2,000,000'=>"$2,000,000",
	'$2,050,000'=>"$2,050,000",
	'$2,100,000'=>"$2,100,000",
	'$2,150,000'=>"$2,150,000",
	'$2,200,000'=>"$2,200,000",
	'$2,250,000'=>"$2,250,000",
	'$2,300,000'=>"$2,300,000",
	'$2,350,000'=>"$2,350,000",
	'$2,400,000'=>"$2,400,000",
	'$2,450,000'=>"$2,450,000",
	'$2,500,000'=>"$2,500,000",
	'$2,550,000'=>"$2,550,000",
	'$2,600,000'=>"$2,600,000",
	'$2,650,000'=>"$2,650,000",
	'$2,700,000'=>"$2,700,000",
	'$2,750,000'=>"$2,750,000",
	'$2,800,000'=>"$2,800,000",
	'$2,850,000'=>"$2,850,000",
	'$2,900,000'=>"$2,900,000",
	'$2,950,000'=>"$2,950,000",
	'$3,000,000'=>"$3,000,000");
	return $policyAmount;
}
$policyAmount = policyAmountList();

// how many years? array for dropdown
function howManyYearsList() {
	$howManyYears = array('10'=>"10",
		'15'=>"15",
		'20'=>"20",
		'25'=>"25",
		'30'=>"30");
		return $howManyYears;
}
$howManyYears = howManyYearsList();

// anyways, let's build the form! (remember that we're using shortcode attributes as variables with their names)
$email_form = '<script src="/wp-content/plugins/aw-contact-form/js/jquery.validate.min.js"></script>
<script src="/wp-content/plugins/aw-contact-form/js/additional-methods.min.js"></script>

<form class="aw-contact-form" method="post" action="' . get_permalink() . '">
	<div class="grid2col">
		<div class="column">
			<h2>About You</h2>
		</div>
		<div class="column">
			<div class="row">
			    <div>
			        <label for="cf_first_name">' . $label_first_name . '</label>
			        <input type="text" name="first_name" id="cf_first_name"  maxlength="50" value="' . $form_data['first_name'] . '" />
			    </div>
			    <div>
			        <label for="cf_middle_name">' . $label_middle_name . '</label>
			        <input type="text" name="middle_name" id="cf_middle_name" class="ignore" maxlength="50" value="' . $form_data['middle_name'] . '" />
			    </div>
			    <div>
			        <label for="cf_last_name">' . $label_last_name . '</label>
			        <input type="text" name="last_name" id="cf_last_name"  maxlength="50" value="' . $form_data['last_name'] . '" />
			    </div>
			</div>
				<div class="row">
				    <div>
				        <label for="cf_gender">' . $label_gender . '</label>
				        <select name="gender" id="cf_gender" class="ignore">
				        	<option selected="selected"></option>';
								foreach ($gender as $key => $value) {
								$email_form .= '<option value="' . $key . '">' . $value . '</option>';
								}
						$email_form .= '</select>
						</select>
				    </div>
				    <div>
				        <label for="cf_state">' . $label_state . '</label>
				        <select name="states" id="cf_state" class="ignore">
							<option selected="selected"></option>';
								foreach ($states as $key => $value) {
								$email_form .= '<option value="' . $key . '">' . $value . '</option>';
								}
						$email_form .= '</select>
				    </div>
				    <div>
				        <label for="cf_month">' . $label_month . '</label>
				        <input type="text" name="birth_month" id="cf_month" maxlength="2" placeholder="MM"'. $form_data['birth_month'] . '" />
				    </div>
				    <div>
				        <label for="cf_day">' . $label_day . '</label>
				        <input type="text" name="birth_day" id="cf_day" maxlength="2" placeholder="DD"'. $form_data['birth_day'] . '" />
				    </div>
				    <div>
				        <label for="cf_year">' . $label_year . '</label>
				        <input type="text" name="birth_year" id="cf_year" maxlength="4" placeholder="YYYY"'. $form_data['birth_year'] . '" />
				    </div>
				</div>
		</div>
    </div>
    
    <div class="grid2col">
    	<div class="column">
			<h2>Quote Info</h2>
		</div>
		<div class="column">
			<div class="row">
				<div>
					<label for="cf_feet">' . $label_feet . '</label>
				        <select name="feet" id="cf_feet" class="ignore" placeholder="Feet">
							<option value="" default selected>Feet</option>';
							foreach ($feet as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
				</div>
				<div>
					<label for="cf_inches">' . $label_inches . '</label>
			        <select name="inches" id="cf_inches" class="ignore" placeholder="Inches">
						<option value="" default selected>Inches</option>';
							foreach ($inches as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
				</div>
				<div>
			        <label for="cf_weight">' . $label_weight . '</label>
			        <input type="text" name="weight" id="cf_weight" maxlength="50" placeholder="lbs"'. $form_data['weight'] . '" />
			    </div>
				<div>
			        <label for="cf_tobacco">' . $label_tobacco . '</label>
			        <select name="tobacco" id="cf_tobacco" class="ignore">
						<option selected="selected"></option>';
							foreach ($tobacco as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
			    </div>
			</div>
			<div class="row">
				<div>
					<label for="cf_policy_amount">' . $label_policy_amount . '</label>
				        <select name="policyAmount" id="cf_policy_amount" class="ignore">
							<option selected="selected"></option>';
							foreach ($policyAmount as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
				</div>
				<div>
					<label for="cf_how_many_years">' . $label_how_many_years . '</label>
				        <select name="howManyYears" id="cf_how_many_years" class="ignore">
							<option selected="selected"></option>';
							foreach ($howManyYears as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
				</div>
			</div>
		</div>
    </div>
    
    <div class="grid2col">
    	<div class="column">
			<h2>Contact</h2>
		</div>
		<div class="column">
			<div class="row">
				<div>
					<label for="cf_email">' . $label_email . '</label>
					<input type="text" name="email" id="cf_email" maxlength="100" value="' . $form_data['email'] . '" />
				</div>
				<div>
					<label for="cf_re_email">' . $label_re_email . '</label>
					<input type="text" name="re_email" id="cf_re_email" maxlength="100" value="' . $form_data['re_email'] . '" />
				</div>
				<div>
					<label for="cf_phone">' . $label_phone . '</label>
					<input type="text" name="phone" id="cf_phone"  maxlength="50" value="' . $form_data['phone'] . '" />
					<p class="phoneNote"><strong>Note:</strong> We will not call you unless you have questions or want to move forward with life insurance.</p>
				</div>
			</div>
			<div class="footerItems">
				<div class="submitButton">
					<input type="submit" value="' . $label_submit . '" name="send" id="cf_send" class="qbutton large center" />
					<label for="cf_subject" style="visibility: hidden;">' . $subject . '</label>
					<input type="hidden" name="subject" id="cf_subject" size="25" maxlength="50" value="' . $form_data['subject'] . '" />
				</div>
				<div class="submitCheckBox">
				</div>
			</div>
		</div>
    </div>
</form>
<script src="/wp-content/plugins/aw-contact-form/js/validate.js?version=1.8"></script>';

if ( $sent == true ) {
    return $info;
} else {
    return $info . $email_form;
}

return $info . $email_form;
 
}
add_shortcode( 'aw_contact', 'aw_contact_form_sc' );
 
?>
