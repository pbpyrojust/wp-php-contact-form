<?php
/*
Plugin Name: AW Contact Form
Plugin URI: http://anthroware.com
Description: A simple contact form for simple needs. Usage: <code>[contact email="your@email.address"]</code>
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
    "subject" => "",
    "label_name" => "Your Name",
    "label_email" => "Your E-mail Address",
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
 
}
add_shortcode( 'aw_contact', 'aw_contact_form_sc' );
 
?>