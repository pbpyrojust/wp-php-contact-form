var $ja = jQuery.noConflict();

$ja(document).ready(function() {

	var headIDContact = document.getElementsByTagName("head")[0];         
	var cssNodeContact = document.createElement('link');
	cssNodeContact.type = 'text/css';
	cssNodeContact.rel = 'stylesheet';
	cssNodeContact.href = '/wp-content/plugins/aw-contact-form/css/styles.css?version=2.1';
	cssNodeContact.media = 'screen';
	headIDContact.appendChild(cssNodeContact);

	$ja(".aw-contact-form").validate({
		  rules: {
		  	ignore: ".ignore",
		    first_name: "required",
		    last_name: "required",
		    birth_month: {
		    	required: true,
		    	digits: true
		    },
		    birth_day: {
		    	required: true,
		    	digits: true
		    },
		    birth_year: {
		    	required: true,
		    	digits: true
		    },
		    weight: {
		    	required: true,
		    	number: true
		    },
		    email: {
		      required: true,
		      email: true
		    },
		    re_email: {
		      equalTo: "#cf_email",
		      required: true,
		      email: true
		    },
		    phone: {
		    	required: true,
		    	phoneUS: true
		    }
		  }
	});
	
});