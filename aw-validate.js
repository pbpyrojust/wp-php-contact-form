// just for the demos, avoids form submit
$j.validator.setDefaults({
  debug: true
});
$j(".aw-contact-form").validate({
  rules: {
  	ignore: ".ignore",
    first_name: "required",
    last_name: "required",
    email: {
      required: true,
      email: true
    },
    re_email: {
      equalTo: "#cf_email"
    }
  }
});