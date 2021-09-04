$("input#login").keyup(function(){
	var handle = $("input#login").val().length;
	
	if(handle >= 6){
		$("input#login").css("background-color", "#4ccc00");
		$("span#bladLogin").html("");
	} else if(handle < 6){
		$("input#login").css("background-color", "#dc5265");
		$("span#bladLogin").html("Login jest za krótki");
	}
});

$("input.pass").keyup(function(){
	var pass1 = $("input#pass1").val();
	var pass2 = $("input#pass2").val();
	
	if(pass1.length >= 8){
		$("input#pass1").css("background-color", "#4ccc00");
		$("span#bladPass1").html("");
	} else if(pass1.length < 8){
		$("input#pass1").css("background-color", "#dc5265");
		$("span#bladPass1").html("Hasło jest za krótkie");
	}
	
	if(pass1 != pass2){
		$("input#pass2").css("background-color", "#dc5265");
		$("span#bladPass2").html("Hasła nie są identyczne");
	} else if(pass1 == pass2 && pass1.length >= 8){
		$("input#pass2").css("background-color", "#4ccc00");
		$("span#bladPass2").html("");
	}
});