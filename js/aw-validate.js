$jQ(function() {

	var headID = document.getElementsByTagName("head")[0];         
	var cssNode = document.createElement('link');
	cssNode.type = 'text/css';
	cssNode.rel = 'stylesheet';
	cssNode.href = '/wp-content/plugins/aw-contact-form.php_/css/styles.css';
	cssNode.media = 'screen';
	headID.appendChild(cssNode);
	
	var headIDUi = document.getElementsByTagName("head")[0];         
	var cssNodeUi = document.createElement('link');
	cssNodeUi.type = 'text/css';
	cssNodeUi.rel = 'stylesheet';
	cssNodeUi.href = '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css';
	cssNodeUi.media = 'screen';
	headIDUi.appendChild(cssNodeUi);

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