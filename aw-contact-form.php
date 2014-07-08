<?php
/*
Plugin Name: AW Contact Form
Plugin URI: http://anthroware.com
Description: A simple contact form for simple needs. Usage: <code>[aw_contact email="your@email.address" subject="Subject You Want To Use"]</code>
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
    "subject" => "Subject",
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
    // the error message when at least one of the required fields are empty:
    "error_empty" => "Please fill in all the required fields.",
    // the error message when the e-mail address is not valid:
    "error_noemail" => "Please enter a valid e-mail address.",
    // and the success message when the e-mail is sent:
    "success" => "Thanks for your e-mail! We'll get back to you as soon as we can."
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
    if ( ! is_email( $form_data['email'] ) ) {
        $error = true;
        $result = $error_noemail;
    }
 
    if ( $error == false ) {
        $email_subject = "[" . get_bloginfo( 'name' ) . "] " . $form_data['subject'];
        $email_message = "First Name: " . $form_data['first_name'] . "\nMiddle Name: " . $form_data['middle_name'] . "\nLast Name: " . $form_data['last_name'] . "\nGender: " . $form_data['gender'] . "\nState: " . $form_data['states'] . "\nBirth Month: " . $form_data['birth_month'] . "\nBirth Day: " . $form_data['birth_day'] . "\nBirth Year: " . $form_data['birth_year'] . "\nHeight in Feet: " . $_POST['feet'] . "\nHeight in Inches: " . $_POST['inches'] . "\nWeight in LBS: " . $form_data['weight'] . "\nTobacco use: " . $_POST['tobacco'] . "\nPolicy amount: " . $_POST['policyAmount'] . "\nYears?: " . $_POST['howManyYears'] . "\nEmail address: " . $form_data['email'] . "\nPhone Number: " . $form_data['phone'] . "\nIP: " . aw_contact_get_the_ip();
        $headers  = "From: " . $form_data['first_name'] . " , " . $form_data['last_name'] . " <" . $form_data['email'] . ">\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
        $headers .= "Content-Transfer-Encoding: 8bit\n";
        wp_mail( $email, $email_subject, $email_message, $headers );
        $result = $success;
        $sent = true;
    }
    // but if $error is still FALSE, put together the POSTed variables and send the e-mail!
    if ( $error == false ) {
        // get the website's name and puts it in front of the subject
        $email_subject = "[" . get_bloginfo( 'name' ) . "] " . $form_data['subject'];
        // get the message from the form and add the IP address of the user below it
        $email_message = "First Name: " . $form_data['first_name'] . "\nMiddle Name: " . $form_data['middle_name'] . "\nLast Name: " . $form_data['last_name'] . "\nGender: " . $form_data['gender'] . "\nState: " . $form_data['states'] . "\nBirth Month: " . $form_data['birth_month'] . "\nBirth Day: " . $form_data['birth_day'] . "\nBirth Year: " . $form_data['birth_year'] . "\nHeight in Feet: " . $_POST['feet'] . "\nHeight in Inches: " . $_POST['inches'] . "\nWeight in LBS: " . $form_data['weight'] . "\nTobacco use: " . $_POST['tobacco'] . "\nPolicy amount: " . $_POST['policyAmount'] . "\nYears?: " . $_POST['howManyYears'] . "\nEmail address: " . $form_data['email'] . "\nPhone Number: " . $form_data['phone'] . "\nIP: " . aw_contact_get_the_ip();
        // set the e-mail headers with the user's name, e-mail address and character encoding
        $headers  = "From: " . $form_data['first_name'] . " , " . $form_data['last_name']  . " <" . $form_data['email'] . ">\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\n";
        $headers .= "Content-Transfer-Encoding: 8bit\n";
        // send the e-mail with the shortcode attribute named 'email' and the POSTed data
        wp_mail( $email, $email_subject, $email_message, $headers );
        // and set the result text to the shortcode attribute named 'success'
        $result = $success;
        // ...and switch the $sent variable to TRUE
        $sent = true;
    }
}

// if there's no $result text (meaning there's no error or success, meaning the user just opened the page and did nothing) there's no need to show the $info variable
if ( $result != "" ) {
    $info = '<div class="info">' . $result . '</div>';
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
	$feet = array('3'=>"3'",
  '4'=>"4'",
  '5'=>"5'",
  '6'=>"6'",
  '7'=>"7'");
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
	'2'=>"$250,000",
	'4'=>"$300,000",
	'5'=>"$350,000",
	'6'=>"$400,000",
	'7'=>"$450,000",
	'8'=>"$500,000",
	'9'=>"$550,000",
	'10'=>"$600,000",
	'11'=>"$650,000",
	'12'=>"$700,000",
	'13'=>"$750,000",
	'14'=>"$800,000",
	'15'=>"$850,000",
	'16'=>"$900,000",
	'17'=>"$950,000",
	'18'=>"$1,000,000",
	'19'=>"$1,050,000",
	'20'=>"$1,100,000",
	'21'=>"$1,150,000",
	'22'=>"$1,200,000",
	'23'=>"$1,250,000",
	'24'=>"$1,300,000",
	'25'=>"$1,350,000",
	'26'=>"$1,400,000",
	'27'=>"$1,450,000",
	'28'=>"$1,500,000",
	'29'=>"$1,550,000",
	'30'=>"$1,600,000",
	'31'=>"$1,650,000",
	'32'=>"$1,700,000",
	'33'=>"$1,750,000",
	'34'=>"$1,800,000",
	'35'=>"$1,850,000",
	'36'=>"$1,900,000",
	'37'=>"$1,950,000",
	'38'=>"$2,000,000",
	'39'=>"$2,050,000",
	'40'=>"$2,100,000",
	'41'=>"$2,150,000",
	'42'=>"$2,200,000",
	'43'=>"$2,250,000",
	'44'=>"$2,300,000",
	'45'=>"$2,350,000",
	'46'=>"$2,400,000",
	'47'=>"$2,450,000",
	'48'=>"$2,500,000",
	'49'=>"$2,550,000",
	'50'=>"$2,600,000",
	'51'=>"$2,650,000",
	'52'=>"$2,700,000",
	'53'=>"$2,750,000",
	'54'=>"$2,800,000",
	'55'=>"$2,850,000",
	'56'=>"$2,900,000",
	'57'=>"$2,950,000",
	'58'=>"$3,000,000");
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
$email_form = '<form class="aw-contact-form" method="post" action="' . get_permalink() . '">
	<div class="grid2col">
		<div class="column">
			<h2>About You</h2>
		</div>
		<div class="column">
			<div class="row">
			    <div>
			        <label for="cf_first_name">' . $label_first_name . '</label>
			        <input type="text" name="first_name" id="cf_first_name" size="26" maxlength="50" value="' . $form_data['first_name'] . '" />
			    </div>
			    <div>
			        <label for="cf_middle_name">' . $label_middle_name . '</label>
			        <input type="text" name="middle_name" id="cf_middle_name" size="26" maxlength="50" value="' . $form_data['middle_name'] . '" />
			    </div>
			    <div>
			        <label for="cf_last_name">' . $label_last_name . '</label>
			        <input type="text" name="last_name" id="cf_last_name" size="26" maxlength="50" value="' . $form_data['last_name'] . '" />
			    </div>
			</div>
				<div class="row">
				    <div>
				        <label for="cf_gender">' . $label_gender . '</label>
				        <select name="gender" id="cf_gender">
				        	<option selected="selected"></option>';
								foreach ($gender as $key => $value) {
								$email_form .= '<option value="' . $key . '">' . $value . '</option>';
								}
						$email_form .= '</select>
						</select>
				    </div>
				    <div>
				        <label for="cf_state">' . $label_state . '</label>
				        <select name="states" id="cf_state">
							<option selected="selected"></option>';
								foreach ($states as $key => $value) {
								$email_form .= '<option value="' . $key . '">' . $value . '</option>';
								}
						$email_form .= '</select>
				    </div>
				    <div>
				        <label for="cf_month">' . $label_month . '</label>
				        <input type="text" name="birth_month" id="cf_month" size="2" maxlength="4" value="MM"'. $form_data['birth_month'] . '" />
				    </div>
				    <div>
				        <label for="cf_day">' . $label_day . '</label>
				        <input type="text" name="birth_day" id="cf_day" size="2" maxlength="4" value="DD"'. $form_data['birth_day'] . '" />
				    </div>
				    <div>
				        <label for="cf_year">' . $label_year . '</label>
				        <input type="text" name="birth_year" id="cf_year" size="8" maxlength="8" value="YYYY"'. $form_data['birth_year'] . '" />
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
				        <select name="feet" id="cf_feet">
							<option selected="selected">Feet</option>';
							foreach ($feet as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
				</div>
				<div>
					<label for="cf_inches">' . $label_inches . '</label>
			        <select name="inches" id="cf_inches">
						<option selected="selected">Inches</option>';
							foreach ($inches as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
				</div>
				<div>
			        <label for="cf_weight">' . $label_weight . '</label>
			        <input type="text" name="weight" id="cf_weight" size="26" maxlength="50" value="lbs"'. $form_data['weight'] . '" />
			    </div>
				<div>
			        <label for="cf_tobacco">' . $label_tobacco . '</label>
			        <select name="tobacco" id="cf_tobacco">
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
				        <select name="policyAmount" id="cf_policy_amount">
							<option selected="selected"></option>';
							foreach ($policyAmount as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
				</div>
				<div>
					<label for="cf_how_many_years">' . $label_how_many_years . '</label>
				        <select name="howManyYears" id="cf_how_many_years">
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
					<input type="text" name="email" id="cf_email" size="25" maxlength="50" value="' . $form_data['email'] . '" />
				</div>
				<div>
					<label for="cf_re_email">' . $label_re_email . '</label>
					<input type="text" name="re_email" id="cf_re_email" size="25" maxlength="50" value="' . $form_data['re_email'] . '" />
				</div>
				<div>
					<label for="cf_phone">' . $label_phone . '</label>
					<input type="text" name="phone" id="cf_phone" size="25" maxlength="50" value="' . $form_data['phone'] . '" />
				</div>
			</div>
		</div>
    </div>
    
     <div>
        <input type="submit" value="' . $label_submit . '" name="send" id="cf_send" />
        <label for="cf_subject" style="visibility: hidden;">' . $subject . '</label>
		<input type="hidden" name="subject" id="cf_subject" size="25" maxlength="50" value="' . $form_data['subject'] . '" />
    </div>
</form>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>';

if ( $sent == true ) {
    return $info;
} else {
    return $info . $email_form;
}

return $info . $email_form;
 
}
add_shortcode( 'aw_contact', 'aw_contact_form_sc' );
 
?>
