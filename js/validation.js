$(document).ready(function(){
	//global vars
	var form = $("#sign_up_form");
	var name = $("#nom");
	var classe = $("#classe");
	var email = $("#email");
	
	
	//On blur
	name.blur(validateName);
	classe.blur(validateClasse);
	email.blur(validateEmail);
	//On key press
	name.keyup(validateName);
	classe.keyup(validateClasse);
	email.keyup(validateEmail);
	// On submitting
	form.submit(function(){
		if(validateName() & validateEmail() & validatePass1() & validatePass2() & validateMessage())
			return true
		else
			return false;
	});
	
	//validation functions
	function validateEmail(){
		//testing regular expression
		var a = $("#email").val();
		var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		//if it's valid email
		if(filter.test(a)){
			email.removeClass("error");
			emailInfo.text("Valid E-mail please, you will need it to log in!");
			emailInfo.removeClass("error");
			return true;
		}
		//if it's NOT valid
		else{
			email.removeClass("sprited");
			email.addClass("error");
			emailInfo.text("Stop cowboy! Type a valid e-mail please :P");
			emailInfo.addClass("error");
			return false;
		}
	}
	function validateName(){
		//if it's NOT valid
		if(name.val().length < 4){
			name.addClass("error");
			nameInfo.text("We want names with more than 3 letters!");
			nameInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			name.removeClass("error");
			nameInfo.text("What's your name?");
			nameInfo.removeClass("error");
			return true;
		}
	}
	
	function validateClasse(){
		//if it's NOT valid
		if(classe.val().length < 3){
			classe.addClass("error");
			classeInfo.text("We want names with more than 3 letters!");
			classeInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			classe.removeClass("error");
			classeInfo.text("What's your name?");
			classeInfo.removeClass("error");
			return true;
		}
	}
	return false;
});