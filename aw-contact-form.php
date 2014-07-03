<?php
/*
Plugin Name: AW Contact Form
Plugin URI: http://anthroware.com
Description: A simple contact form for simple needs. Usage: <code>[aw_contact email="your@email.address"]</code>
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
    "subject" => "Term Price Quote Contact Form Inquiry",
    "label_first_name" => "First Name",
    "label_middle_name" => "Middle Name",
    "label_last_name" => "Last Name",
    "label_gender" => "Gender",
    "label_state" => "What State Do You Live In?",
    "label_birth_month" => "Date of Birth",
    "label_height" => "What Is Your Height?",
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
    $required_fields = array( "first_name", "email" );
 
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
        $email_message = "First Name: " . $form_data['first_name'] . "\nIP: " . aw_contact_get_the_ip();
        $headers  = "From: " . $form_data['name'] . " <" . $form_data['email'] . ">\n";
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
        $email_message = "First Name: " . $form_data['first_name'] . "\nIP: " . aw_contact_get_the_ip();
        // set the e-mail headers with the user's name, e-mail address and character encoding
        $headers  = "From: " . $form_data['first_name'] . " <" . $form_data['email'] . ">\n";
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
// anyways, let's build the form! (remember that we're using shortcode attributes as variables with their names)
$email_form = '<?php $states = statesList(); ?>
<form class="aw-contact-form" method="post" action="' . get_permalink() . '">
	<div class="grid2col">
		<div class="column">
			<h2>About You</h2>
		</div>
		<div class="column">
			<div class="row">
			    <div>
			        <label for="cf_first_name">' . $label_first_name . '</label>
			        <input type="text" name="first_name" id="cf_first_name" size="25" maxlength="50" value="' . $form_data['first_name'] . '" />
			    </div>
			    <div>
			        <label for="cf_middle_name">' . $label_middle_name . '</label>
			        <input type="text" name="middle_name" id="cf_middle_name" size="25" maxlength="50" value="' . $form_data['middle_name'] . '" />
			    </div>
			    <div>
			        <label for="cf_last_name">' . $label_last_name . '</label>
			        <input type="text" name="last_name" id="cf_last_name" size="25" maxlength="50" value="' . $form_data['last_name'] . '" />
			    </div>
			    <div class="row">
			    <div>
			        <label for="cf_gender">' . $label_gender . '</label>
			        <select name="gender" id="cf_gender">
			        	<option selected="selected"></option>
						<option value="male" value="' . $form_data['male'] . '">Male</option>
						<option value="female" value="' . $form_data['female'] . '">Female</option>
					</select>
			    </div>
			    <div>
			        <label for="cf_state">' . $label_state . '</label>
			        <select name="state" id="cf_state">
						<option selected="selected"></option>';
							foreach ($states as $key => $value) {
							$email_form .= '<option value="' . $key . '">' . $value . '</option>';
							}
					$email_form .= '</select>
			    </div>
			    <div>
			        <label for="cf_month">' . $label_birth_month . '</label>
			        <input type="text" name="month" id="cf_month" size="2" maxlength="2" value="MM' . $form_data['birth_month'] . '" />
			    </div>
			    <div>
			        <label for="cf_day">' . $label_birth_day . '</label>
			        <input type="text" name="day" id="cf_day" size="2" maxlength="2" value="DD' . $form_data['birth_day'] . '" />
			    </div>
			    <div>
			        <label for="cf_year">' . $label_birth_year . '</label>
			        <input type="text" name="year" id="cf_year" size="4" maxlength="4" value="YYYY' . $form_data['birth_year'] . '" />
			    </div>
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
							<option selected="selected">Feet</option>
								<?php foreach($feet as $key=>$value) { ?>
								<option value="<?php echo $key; ?>"><?php $value; ?></option>
								<?php } ?>
						</select>
				</div>
				<div>
					<label for="cf_inches">' . $label_inches . '</label>
			        <select name="inches" id="cf_inches">
						<option selected="selected">Inches</option>
							<?php foreach($inches as $key=>$value) { ?>
							<option value="<?php echo $key; ?>"><?php $value; ?></option>
							<?php } ?>
					</select>
				</div>
				<div>
			        <label for="cf_weight">' . $label_weight . '</label>
			        <input type="text" name=weight id="cf_weight" size="25" maxlength="50" value="' . $form_data['weight'] . '" />
			    </div>
				<div>
			        <label for="cf_tobacco">' . $label_tobacco . '</label>
			        <select name="tobacco" id="cf_tobacco">
						<option selected="selected"></option>
							<?php foreach($tobacco as $key=>$value) { ?>
							<option value="<?php echo $key; ?>"><?php $value; ?></option>
							<?php } ?>
					</select>
			    </div>
			</div>
			<div class="row">
				<div>
					<label for="cf_policy_amount">' . $label_policy_amount . '</label>
				        <select name="policy_amount" id="cf_policy_amount">
							<option selected="selected"></option>
								<?php foreach($policy_amount as $key=>$value) { ?>
								<option value="<?php echo $key; ?>"><?php $value; ?></option>
								<?php } ?>
						</select>
				</div>
				<div>
					<label for="cf_how_many_years">' . $label_how_many_years . '</label>
				        <select name="how_many_years" id="cf_how_many_years">
							<option selected="selected"></option>
								<?php foreach($how_many_years as $key=>$value) { ?>
								<option value="<?php echo $key; ?>"><?php $value; ?></option>
								<?php } ?>
						</select>
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
</form>';

if ( $sent == true ) {
    return $info;
} else {
    return $info . $email_form;
}

return $info . $email_form;
 
}
add_shortcode( 'aw_contact', 'aw_contact_form_sc' );
 
?>
