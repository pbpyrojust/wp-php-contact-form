var $jQ = jQuery.noConflict();

$jQ(function() {

	var headID = document.getElementsByTagName("head")[0];         
	var cssNode = document.createElement('link');
	cssNode.type = 'text/css';
	cssNode.rel = 'stylesheet';
	cssNode.href = '/wp-content/plugins/aw-contact-form.php_/css/styles.css';
	cssNode.media = 'screen';
	headID.appendChild(cssNode);
	

});

$jQ(".aw-contact-form").validate({
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
	      equalTo: "#cf_email"
	    },
	    phone: {
	    	required: true,
	    	phoneUS: true
	    }
	  }
});

if ($jQ("input").is(".error")) {
    $jQ('input.error').parent().append('<i class="fa fa-times" style="position:absolute; width:50px; height:50px; top:10px; left 10px;"></i>');
}