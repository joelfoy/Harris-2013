// Validate email Function
function isValidEmailAddress(emailAddress) {
var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
return pattern.test(emailAddress);
}

$(document).ready(function(){ 

//Hide ALL errors
$('.error').hide();


// Search Label Replacement 

var placeholder = $('.searchBar').val();
$('.searchBar').focus(function(){
if (this.value == placeholder) {
	$(this).val('');
};
}).blur(function() {
if (this.value == '') {
	$(this).val(placeholder);
};

});  

//});

// Even/Odd table highlighting

$("div.machine-specs tbody tr:even").addClass("even");//Stripes

$(".sidebar-list:last").css({'border' : 'none'});

// more button
$(".view-machine").hide();
$(".search-result").hover(function() {
	$(this).children('.view-machine').show();
 	
 },
 	function(){
 	$(".view-machine").hide();

});
////////////////////////////////////////////////////////////////////////////////////////
//Feedbruner Signup!
$(function() {
	//hide error
	$('.error').hide();
	//on submit ->
	$('.feedBurner .button').click(function() {
		var email = $("input#email").val();
		if (email == "") {
		$("#subscribeError").show();
		$("#email").focus();
		return false;
	}
	
	});
});
//end Feedburner Signup!
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////
//START CONTACT PAGE FORM
////////////////////////////////////////////////////////////////////////////////////////

$(function() {
//contact page handler
//hide all errors
	$('.error').hide();
//on submit ->	
	$("#contactForm #submit_btn").click(function() {
								
//Validation
								
	$('.error').hide();
	
	var title = $("input#title").val();
	
	var name = $("input#name").val();  
        if (name == "") {  
      	$("#emptyField_error").show();
      	$("label#name_error").show();  
      	$("input#name").focus();  
      	return false;  
    }

	var firstName = $("input#firstName").val();  
        if (firstName == "") {  
      	$("#emptyField_error").show();
      	$("label#firstNameame_error").show();  
      	$("input#firstName").focus();  
      	return false;  
    }
    
    var lastName = $("input#lastName").val();  
        if (lastName == "") {  
      	$("#emptyField_error").show();
      	$("label#lastName_error").show();  
      	$("input#lastName").focus();  
      	return false;  
    }
	
	var company = $("input#company").val();  
        if (company == "") {  
      	$("#emptyField_error").show();
      	$("label#company_error").show();  
      	$("input#company").focus();  
      	return false;  
    }
	
	var email = $("input#email").val();  
        if (email == "") { 
      $("#emptyField_error").show(); 
      $("label#email_error").show();  
      $("input#email").focus();  
      return false;  
    } else if (!isValidEmailAddress(email)) {
      $("#emptyField_error").show();
      $("#email_error").html("Please use a valid email."); 
      $("label#email_error").show();  
      $("input#email").focus();  
      return false;
    }
	
	var phone = $("input#phone").val();  
        if (phone == "") {  
      	$("#emptyField_error").show();
      	$("label#phone_error").show();  
      	$("input#phone").focus();  
      	return false;  
    }
	
	var address = $("input#address").val();
		if (address == "") {  
	  	$("#emptyField_error").show();	
      	$("label#address_error").show();  
      	$("input#address").focus();  
      	return false;  
    } 
	
	var city = $("input#city").val();  
        if (city == "") {  
      	$("#emptyField_error").show();
      	$("label#city_error").show();  
      	$("input#city").focus();  
      	return false;  
    } 
	
	var state = $("input#state").val();  
        if (state == "") {  
      	$("#emptyField_error").show();
      	$("label#state_error").show();  
      	$("input#state").focus();  
      	return false;  
    } 
	
	var zip = $("input#zip").val();  
        if (zip == "") { 
      	$("#emptyField_error").show();
      	$("label#zip_error").show();  
      	$("input#zip").focus();  
      	return false;  
    }
	
	var country = $("select#country").val();
		if (country == "Please Choose") {
		$("#emptyField_error").show();
      	$("label#country_error").show();  
      	$("#country").focus();  
      	return false;	
	}
	
	var machine = $("select#machine").val();
		if (machine == "Pick your machine") {
		$("#emptyField_error").show();
      	$("label#machine_error").show();  
      	$("#machine").focus();  
      	return false;	
	}
	
	var source = $("select#source").val();
		if (source == "Please Choose") {
		$("#emptyField_error").show();
      	$("label#source_error").show();  
      	$("#source").focus();  
      	return false;
	}
		
	var comments = $("textarea#formcomments").val();
		if (comments == "") {
		$("#emptyField_error").show();
      	$("label#formcomments_error").show();  
      	$("#formcomments").focus();  
      	return false;
	}
	
	var dataString = 'name=' + name + '&company=' + company + '&email=' + email + '&phone=' + phone + '&address=' + address + '&city=' + city + '&state=' + state + '&zip=' + zip + '&country=' + country + '&machine=' + machine + '&source=' + source + '&formcomments=' + comments;  
	
	// alert (dataString); return false;
	
	$.ajax({
		type: "POST",
		url: "http://www.harrisequip.com/wp-content/themes/Harris_v2/includes/contact-process.php", 				data: dataString,
		success: function()	{
			_gaq.push(['_trackPageview', '/contact-complete.php']);
			$('#contactForm').fadeOut(1000, function() {
			$('#contactForm').replaceWith("<div id='message'></div>");
			$('#message').html("<h3>Information Received</h3>")
			.append("<p>We have received your information request. Someone from Harris will be in touch with you soon. If you want, at any point, to contact Harris directly you can reach us at 800.373.9131 or 770.631.7290</p>")
			.append("<h4 class='thankYou'>Thank You</h4>")
			
			
			});
			},
		error: function() {
			$('#questionsForm').append("<h4 class=''>There was an error sending your form. Please try again later or contact your <a href='http://www.harrisequip.com/sales'>Local Sales Representative</a></h4>");
		}
		
		
		
	
	});
	return false;
	
	});

});
////////////////////////////////////////////////////////////////////////////////////////
//END CONTACT PAGE FORM
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////
//START MACHING INFO REQUEST FORM
////////////////////////////////////////////////////////////////////////////////////////
$(function() {
//Machine Info Request handler
//hide all errors
	$('.error').hide();
//on submit ->	
	$("#questionsForm #submit_btn").click(function() {
								
//Validation
								
		$('.error').hide();
	
	var title = $("input#title").val();
	
	var name = $("input#name").val();  
        if (name == "") {  
      $("#emptyField_error").show();
      $("label#name_error").show();  
      $("input#name").focus();  
      return false;  
    }

	var firstName = $("input#firstName").val();  
        if (firstName == "") {  
      $("#emptyField_error").show();
      $("label#firstNameame_error").show();  
      $("input#firstName").focus();  
      return false;  
    }
    
    var lastName = $("input#lastName").val();  
        if (lastName == "") {  
      $("#emptyField_error").show();
      $("label#lastName_error").show();  
      $("input#lastName").focus();  
      return false;  
    }
	
	var company = $("input#company").val();  
        if (company == "") {  
      $("#emptyField_error").show();
      $("label#company_error").show();  
      $("input#company").focus();  
      return false;  
    }
	
	var email = $("input#email").val();  
        if (email == "") { 
      $("#emptyField_error").show(); 
      $("label#email_error").show();  
      $("input#email").focus();  
      return false;  
    } else if (!isValidEmailAddress(email)) {
      $("#emptyField_error").show();
      $("#email_error").html("Please use a valid email."); 
      $("label#email_error").show();  
      $("input#email").focus();  
      return false;
    }
	
	var phone = $("input#phone").val();  
        if (phone == "") {  
      $("#emptyField_error").show();
      $("label#phone_error").show();  
      $("input#phone").focus();  
      return false;  
    }
	
	var address = $("input#address").val();
		if (address == "") {  
	  $("#emptyField_error").show();	
      $("label#address_error").show();  
      $("input#address").focus();  
      return false;  
    } 
	
	var city = $("input#city").val();  
        if (city == "") {  
      $("#emptyField_error").show();
      $("label#city_error").show();  
      $("input#city").focus();  
      return false;  
    } 
	
	var state = $("input#state").val();  
        if (state == "") {  
      $("#emptyField_error").show();
      $("label#state_error").show();  
      $("input#state").focus();  
      return false;  
    } 
	
	var zip = $("input#zip").val();  
        if (zip == "") { 
      $("#emptyField_error").show();
      $("label#zip_error").show();  
      $("input#zip").focus();  
      return false;  
    }
	
	var country = $("select#country").val();
		if (country == "Please Choose") {
		$("#emptyField_error").show();
      	$("label#country_error").show();  
      	$("#country").focus();  
      	return false;	
	}
	
	var machine = $("select#machine").val();
		if (machine == "Pick your machine...") {
		$("#emptyField_error").show();
      	$("label#machine_error").show();  
      	$("#machine").focus();  
      	return false;	
	}
	
	var source = $("select#source").val();
		if (source == "Please Choose") {
		$("#emptyField_error").show();
      	$("label#source_error").show();  
      	$("#source").focus();  
      	return false;
	}
		
	var comments = $("textarea#formcomments").val();
		if (comments == "") {
		$("#emptyField_error").show();
      	$("label#formcomments_error").show();  
      	$("#formcomments").focus();  
      	return false;
	}
	
	var dataString = 'title=' + title + '&name=' + name + '&company=' + company + '&email=' + email + '&phone=' + phone + '&address=' + address + '&city=' + city + '&state=' + state + '&zip=' + zip + '&country=' + country + '&machine=' + machine + '&source=' + source + '&formcomments=' + comments;  
	
	// alert (dataString); return false;
	
	$.ajax({
		type: "POST",
		url: "http://www.harrisequip.com/wp-content/themes/Harris_v2/includes/machineInfo-process.php", //don't forget to change the URL
		data: dataString,
		success: function()	{
			// Track as Pageview
			$.getScript( "http://www.googleadservices.com/pagead/conversion.js" );
			_gaq.push(['_trackPageview', '/machine-request-complete.php']);
			// Track Conversion
			var google_conversion_id = 1026911858;
			var google_conversion_language = "en";
			var google_conversion_format = "3";
			var google_conversion_color = "ffffff";
			var google_conversion_label = "5RW5CJbUlQIQ8tzV6QM";
			var google_conversion_value = 0;
			if (100) {
                google_conversion_value = 0;
            }
			
			
			// Form Completion Animation
			$("#questionsForm").fadeOut(1000, function() {
			$('#questionsForm').html("<div id='message'></div>");
			$('#message').html("<h3>Information Received</h3>")
			.append("<p>Thank you for showing interest in Harris' products. We have received your information request and someone from Harris will be in touch with you soon. If you want, at any point, to contact Harris directly you can reach us at 800.373.9131 or 770.631.7290</p>")
			.append("<h4 class='thankYou'>Thank You</h4>")
			$('#questionsForm').fadeIn(1000);
			});
		},
		error: function() {
			$('#questionsForm').append("<h4 class=''>There was an error sending your form. Please try again later or contact your <a href='http://www.harrisequip.com/sales'>Local Sales Representative</a></h4>");
		}
	
	});
	return false;
	
	});

});
////////////////////////////////////////////////////////////////////////////////////////
//END MACHINE INFO REQUEST FORM
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////
//START SERVICE REQUEST FORM
////////////////////////////////////////////////////////////////////////////////////////
$(function() {
//Machine Info Request handler
//hide all errors
	$('.error').hide();
//on submit ->	
	$("#serviceForm form #submit_btn").click(function() {
								
//Validation
								
		$('.error').hide();
	
	var title = $("input#title").val();
	
	var name = $("input#name").val();  
        if (name == "") {  
      $("#emptyField_error").show();
      $("label#name_error").show();  
      $("input#name").focus();  
      return false;  
    }

	var firstName = $("input#firstName").val();  
        if (firstName == "") {  
      $("#emptyField_error").show();
      $("label#firstNameame_error").show();  
      $("input#firstName").focus();  
      return false;  
    }
    
    var lastName = $("input#lastName").val();  
        if (lastName == "") {  
      $("#emptyField_error").show();
      $("label#lastName_error").show();  
      $("input#lastName").focus();  
      return false;  
    }
	
	var company = $("input#company").val();  
        if (company == "") {  
      $("#emptyField_error").show();
      $("label#company_error").show();  
      $("input#company").focus();  
      return false;  
    }
	
	var email = $("input#email").val();  
        if (email == "") { 
      $("#emptyField_error").show(); 
      $("label#email_error").show();  
      $("input#email").focus();  
      return false;  
    } else if (!isValidEmailAddress(email)) {
      $("#emptyField_error").show();
      $("#email_error").html("Please use a valid email."); 
      $("label#email_error").show();  
      $("input#email").focus();  
      return false;
    }
	
	var phone = $("input#phone").val();  
        if (phone == "") {  
      $("#emptyField_error").show();
      $("label#phone_error").show();  
      $("input#phone").focus();  
      return false;  
    }
	
	var address = $("input#address").val();
		if (address == "") {  
	  $("#emptyField_error").show();	
      $("label#address_error").show();  
      $("input#address").focus();  
      return false;  
    } 
	
	var city = $("input#city").val();  
        if (city == "") {  
      $("#emptyField_error").show();
      $("label#city_error").show();  
      $("input#city").focus();  
      return false;  
    } 
	
	var state = $("input#state").val();  
        if (state == "") {  
      $("#emptyField_error").show();
      $("label#state_error").show();  
      $("input#state").focus();  
      return false;  
    } 
	
	var zip = $("input#zip").val();  
        if (zip == "") { 
      $("#emptyField_error").show();
      $("label#zip_error").show();  
      $("input#zip").focus();  
      return false;  
    }
	
	var country = $("select#country").val();
		if (country == "Please Choose") {
		$("#emptyField_error").show();
      	$("label#country_error").show();  
      	$("#country").focus();  
      	return false;	
	}
	
	var machine = $("select#machine").val();
		if (machine == "Pick your machine...") {
		$("#emptyField_error").show();
      	$("label#machine_error").show();  
      	$("#machine").focus();  
      	return false;	
	}
	
	var serial = $("input#serial").val();  
        if (zip == "") { 
      $("#emptyField_error").show();
      $("label#serial_error").show();  
      $("input#serial").focus();  
      return false;  
    }
		
	var issue = $("textarea#issue").val();
		if (issue == "") {
		$("#emptyField_error").show();
      	$("label#issue_error").show();  
      	$("#issue").focus();  
      	return false;
	}
	
	var dataString = 'name=' + name + '&company=' + company + '&email=' + email + '&phone=' + phone + '&address=' + address + '&city=' + city + '&state=' + state + '&zip=' + zip + '&country=' + country + '&machine=' + machine + '&serial=' + serial + '&issue=' + issue;  
	
	// alert (dataString); return false;
	
	$.ajax({
		type: "POST",
		url: "http://www.harrisequip.com/wp-content/themes/Harris_v2/includes/serviceRequest-process.php", //don't forget to change the URL
		data: dataString,
		success: function(msg)	{
			// Track as Pageview
			_gaq.push(['_trackPageview', '/service-request-complete.php']);
			// Track Conversion
			var google_conversion_id = 1026911858;
			var google_conversion_language = "en";
			var google_conversion_format = "3";
			var google_conversion_color = "ffffff";
			var google_conversion_label = "5RW5CJbUlQIQ8tzV6QM";
			var google_conversion_value = 0;
			if (100) {
                google_conversion_value = 0;
            }
			$.getScript( "http://www.googleadservices.com/pagead/conversion.js" );
			
			// Form Completion Animation
			$("#serviceForm").fadeOut(1000, function() {
				$('#serviceForm').html("<div id='message'></div>");
				$('#message').html("<h3>Information Received</h3>")
				.append("<p>Your service request has been processed and a Harris service technician will follow up on your request. If you want, at any point, to contact Harris directly you can reach us at 800.373.9131 or 770.631.7290</p>")
				.append("<h4 class='thankYou'>Thank You</h4>")
				$('#serviceForm').fadeIn(1000);
				$('body').animate({
					scrollTop: 0
				}, 400);
			});
		},
		error: function() {
			$('#serviceForm').append("<h4 class=''>There was an error sending your form. Please try again later or contact your <a href='http://www.harrisequip.com/sales'>Local Sales Representative</a></h4>");
		}
	
	});
	return false;
	
	});

});
////////////////////////////////////////////////////////////////////////////////////////
//END SERVICE REQUEST FORM
////////////////////////////////////////////////////////////////////////////////////////



$(document).ready(function(){
	$(".lightbox").fancybox({
		'overlayShow': true,
		'overlayColor': '#111',
		'titlePosition': 'over',
		//'titleShow': false,
		'overlayOpacity': .8
	});

});

$(document).ready(function(){
	$(".video").click(function() {
		$.fancybox({
			'overlayColor'	: '#111',
			'overlayOpacity': .8,
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'fade',
			'transitionOut'	: 'fade',
			'title'			: this.title,
			'width'			: 680,
			'height'		: 495,
			'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
			'type'			: 'swf'
		});
	
		return false;
	});
});

////////////////////////////////////////////////////////////////////////////////////////
//START E-NEWSLETTER SIGNUP
////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() { /*place jQuery actions here*/ 
						//email validation
						function isValidEmailAddress(emailAddress) {
						
						var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
						
						return pattern.test(emailAddress);
						
						}

	$('.error').hide();
	$("#emailSignup #emailSubmit").click(function() {
								
								// validate code
		
		$('.error').show(); 
	
      var email = $("input#email").val();  
        if (email == "") { 
      $(".signupMessage").replaceWith("<p class='error signupError signupMessage'>Your email is required.</p>"); 
      $('.error').show();
      //$("label#email_error").show();  
      
      $("input#email").focus();  
      return false;  
    }  
    	if (!isValidEmailAddress(email)) {
    	$(".signupMessage").replaceWith("<p class='error signupError signupMessage'>Please enter a valid email.</p>");
    	$('.error').show(); 
      //$("label#email_error").show();  
      
      $("input#email").focus();  
      return false;
    }

    	
	var dataString = "email=" + email;  
	
	$('.loading').show();
	
	
	// alert (dataString); return false;
	
	$.ajax({
		type: "POST",
		url: "http://www.harrisequip.com/wp-content/themes/Harris_v2/includes/signup_process.php",
		data: dataString,
		success: function()	{
			// Pageview Tracking
			_gaq.push(['_trackPageview', '/email-signup-complete.php']);
			// Conversion Tracking
			goog_snippet_vars = function() {
			    var w = window;
			    w.google_conversion_id = 1026911858;
			    w.google_conversion_label = "yJ9NCJbbtAIQ8tzV6QM";
			    w.google_conversion_value = 0;
			  }
			  // DO NOT CHANGE THE CODE BELOW.
			  goog_report_conversion = function(url) {
			    goog_snippet_vars();
			    window.google_conversion_format = "3";
			    window.google_is_call = true;
			    var opt = new Object();
			    opt.onload_callback = function() {
			    if (typeof(url) != 'undefined') {
			      window.location = url;
			    }
			  }
			  var conv_handler = window['google_trackConversion'];
			  if (typeof(conv_handler) == 'function') {
			    conv_handler(opt);
			  }
			}
			$.getScript( "http://www.googleadservices.com/pagead/conversion.js" );
			// Form Completion Animation
			$('.newsletter_signup').replaceWith("<div id='signupMessage'></div>");
			$('#signupMessage').html("<h6 class='signup_complete'>Sign Up Complete!</h6>")
			.append("<p class='signupMessage'>You have been signed up for the Harris e-News email</p>")
			.append("<p class='thankYou'>Thank You</p>")
			.hide()
			.fadeIn(2000, function() {
				$('#message')
				.pause(2000)
				.fadeIn(0, function() {
				$('#emailForm').slideToggle();
									   });
			});
		}
	
	});
	return false;
	
	});


}); 

////////////////////////////////////////////////////////////////////////////////////////
//END E-NEWSLETTER SIGNUP
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////
//START E-NEWSLETTER REMOVAL
////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function() { /*place jQuery actions here*/ 
						//email validation
						function isValidEmailAddress(emailAddress) {
						
						var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
						
						return pattern.test(emailAddress);
						
						}

	$('.error').hide();
	$("#emailRemove #emailSubmit").click(function() {
								
								// validate code
		
		$('.error').show(); 
	
      var email = $("input#email").val();  
        if (email == "") { 
      $(".removeMessage").replaceWith("<p class='error signupError signupMessage'>Your email is required.</p>"); 
      $('.error').show();
      //$("label#email_error").show();  
      
      $("input#email").focus();  
      return false;  
    }  
    	if (!isValidEmailAddress(email)) {
    	$(".removeMessage").replaceWith("<p class='error signupError signupMessage'>Please enter a valid email.</p>");
    	$('.error').show(); 
      //$("label#email_error").show();  
      
      $("input#email").focus();  
      return false;
    }

    	
	var dataString = "email=" + email;  
	
	$('.loading').show();
	
	
	// alert (dataString); return false;
	
	$.ajax({
		type: "POST",
		url: "http://www.harrisequip.com/wp-content/themes/Harris_v2/includes/unsubscribe-process.php",
		data: dataString,
		success: function()	{
			$('.newsletter_removal').replaceWith("<div id='removalMessage'></div>");
			$('#removalMessage').html("<h6 class='removal_complete'>You have been removed</h6>")
			.append("<p class='signupMessage'>We are sorry you no longer wish to receive Harris Emails. You will receive an email confirming your address removal.</p>")
			.append("<p class='thankYou'>Thank You</p>")
			.hide()
			.fadeIn(2000, function() {
				$('#message')
				.pause(2000)
				.fadeIn(0, function() {
				$('#emailForm').slideToggle();
									   });
			});
		}
	
	});
	return false;
	
	});


}); 

////////////////////////////////////////////////////////////////////////////////////////
//END E-NEWSLETTER Removal
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////
//Event Tracking Functions
////////////////////////////////////////////////////////////////////////////////////////

 
////////////////////////////////////////////////////////////////////////////////////////
//END Event Tracking Functions
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////
//Blog Comments Form
////////////////////////////////////////////////////////////////////////////////////////

$("#commentform #submit").click(function() {
	var comment = $("#comment").val();
	if (comment == "") {
	$("#commenterror").show();
	$("#comment").focus();
	return false;
	}

});

$("a.remove").removeAttr("href");

$("a.remove").click(function() {
	$(this).remove();
	$("#machineAnnouncement").html("<em class='required'><small>Please select a machine below</small></em>");
	$("#machine option:selected").removeAttr("selected");
	$("#choose").attr('selected', 'selected');
});

});