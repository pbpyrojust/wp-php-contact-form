// just for the demos, avoids form submit
$j.validator.setDefaults({
  debug: true
});
$j(".aw-contact-form").validate({
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
    	digits: true
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