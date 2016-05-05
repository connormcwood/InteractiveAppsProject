$(function() {
	$("#bmicalculatesubmit").click(function () {
    if($("#footheight").val() && $("#inchheight").val() && $("#stoneweight").val() && $("#poundweight").val()){
        var footheight = $("#footheight").val() * 12;
		var inchheight = $("#inchheight").val() * 1;
		var overallheight = footheight + inchheight;
        var weight = ($("#stoneweight").val() * 14) + ($("#poundweight").val() * 1);
		var overallsum = ( weight / ( overallheight * overallheight ));
        $("#bmi").val( overallsum * 703);
		var overallvalue = (overallsum * 703);
		var div = document.getElementById('bmivalue');
		div.innerHTML = 'Your BMI is: ' + overallvalue;
    }
	});	
	$("#prospects_form").submit(function(e) {
    e.preventDefault();
	});
	$.validator.addMethod('strongPassword', function(value, element) {
		return this.optional(element)
		|| value.length >= 6
		&& /\d/.test(value)
		&& /[a-z]/i.test(value);
	}, '<br /><div class="warning">Your Password needs to be at least 6 characters long and contain at least one number and one char</div>\'.')
	
	$("#bmicalculate-form").validate({
	rules: {
		footheight: {
			required: true,
			number: true,
			nowhitespace: true
		},
		inchheight: {
			required: true,
			number: true,
			nowhitespace: true
		},
		stoneweight: {
			required: true,
			number: true,
			nowhitespace: true
		},
		poundweight: {
			required: true,
			number: true,
			nowhitespace: true
		}
		},
	messages: {
		footheight: {
			required: '<br /><div class="warning">Please Enter Your Height In Foot</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>',
			nowhitespace: '<br /><div class="warning">Please Remove The White Space</div>'
		},
		inchheight: {
			required: '<br /><div class="warning">Please Enter Your Height In Inches</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>',
			nowhitespace: '<br /><div class="warning">Please Remove The White Space</div>'
		},
		stoneweight: {
			required: '<br /><div class="warning">Please Enter Your Weight In Stone</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>',
			nowhitespace: '<br /><div class="warning">Please Remove The White Space</div>'
		},
		poundweight: {
			required: '<br /><div class="warning">Please Enter Your Weight In Pounds</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>',
			nowhitespace: '<br /><div class="warning">Please Remove The White Space</div>'
		}
	}
	});	
	$("#registration-form").validate({
	rules: {
		firstname: {
			required: true,
			nowhitespace: true,
			lettersonly: true
		},
		secondname: {
			required: true,
			nowhitespace: true,
			lettersonly: true
		},
		email: {
			required: true,
			email: true
		},
		username: {
			required: true
		},
		password: {
			required: true,
			strongPassword: true
		},
		password2: {
			required: true,
			equalTo: "#password"
		}
	},
	messages: {
		firstname: {
			required: '<br /><div class="warning">Please Enter Your Forename</div>',
			nowhitespace: '<br /><div class="warning">Please Remove The White Space</div>',
			lettersonly: '<br /><div class="warning">Firstname should only include letters</div>'
		    },
		secondname: {
			required: '<br /><div class="warning">Please Enter Your Surname</div>',
			nowhitespace: '<br /><div class="warning">Please Remove The White Space</div>',
			lettersonly: '<br /><div class="warning">Secondname should only include letters</div>'
		    },	
		email: {
			required: '<br /><div class="warning">Please Enter Your Email Address</div>',
			email: '<br /><div class="warning">Please Enter A Valid Email Address</div>'
		    },		
		username: {
			required: '<br /><div class="warning">Please Enter A Valid Username</div>'
			},
		password: {
			required: '<br /><div class="warning">Please Enter A Valid Password</div>',
			strongPassword: '<br /><div class="warning">Please enter a password which includes at least 6 characters, a number and a character</div>'
			},
		password2: {
			required: '<br /><div class="warning">Please Enter A Valid Password</div>',
			equalTo: '<br /><div class="warning">Please Enter A Password Which Matches</div>'
		    }			
		}
	});
	$("#login-form").validate({
	rules: {
		username: {
			required: true
		},
		password: {
			required: true
		}
		},
	messages: {
		username: {
			required: '<br /><div class="warning">Please Enter Your Forename</div>'
			},
		password: {
			required: '<br /><div class="warning">Please Enter A Valid Password</div>'
			}
		}
	});	
	$("#register2-form").validate({
	rules: {
		age: {
			required: true,
			number: true
		},
		footheight: {
			required: true,
			number: true
		},
		inchheight: {
			required: true,
			number: true
		},
		stoneweight: {
			required: true,
			number: true
		},
		poundweight: {
			required: true,
			number: true
		},
		gym : {
			required: true
		}
		},
	messages: {
		age: {
			required: '<br /><div class="warning">Please Enter Your Age In The Age Field</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>'		
		},
		footheight: {
			required: '<br /><div class="warning">Please Enter Your Height In Foot</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>'
		},
		inchheight: {
			required: '<br /><div class="warning">Please Enter Your Height In Inches</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>'
		},
		stoneweight: {
			required: '<br /><div class="warning">Please Enter Your Weight In Stone</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>'
		},
		poundweight: {
			required: '<br /><div class="warning">Please Enter Your Weight In Pounds</div>',
			number: '<br /><div class="warning">Please Enter A Number In the Field</div>'
		},
		gym: {
			required: '<br /><div class="warning">Please Enter A Valid GYM In The Field</div>'			
		}
	}
	});	
	jQuery.extend(jQuery.validator.messages, {
    required: '<br /><div class="warning">This field is required.</div>',
    remote: '<br /><div class="warning">Please fix this field.</div>',
    email: '<br /><div class="warning">Please enter a valid email address.</div>',
    url: '<br /><div class="warning">Please enter a valid URL.</div>',
    date: '<br /><div class="warning">Please enter a valid date.</div>',
    dateISO: '<br /><div class="warning">Please enter a valid date (ISO).</div>',
    number: '<br /><div class="warning">Please enter a valid number.</div>',
    digits: '<br /><div class="warning">Please enter only digits.</div>',
    creditcard: '<br /><div class="warning">Please enter a valid credit card number.</div>',
    equalTo: '<br /><div class="warning">Please enter the same value again.</div>',
    accept: '<br /><div class="warning">Please enter a value with a valid extension.</div>',
    maxlength: jQuery.validator.format('<br /><div class="warning">Please enter no more than {0} characters.</div>'),
    minlength: jQuery.validator.format('<br /><div class="warning">Please enter at least {0} characters.</div>'),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format('<br /><div class="warning">Please enter a value between {0} and {1}.</div>'),
    max: jQuery.validator.format('<br /><div class="warning">Please enter a value less than or equal to {0}.</div>'),
    min: jQuery.validator.format('<br /><div class="warning">Please enter a value greater than or equal to {0}.</div>')
	});
});