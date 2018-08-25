$(document).ready(function() {
	processLogin();
	processSignup();
});
function processLogin(){
	$("#login").submit(function() {
		var data={};
		$("#login input").each(function(k,v) {
			if(!$(v).val().length){
				alert("error");
				return false;
			}
			data[$(v).attr('name')]=$(v).val();
		});
		$.ajax({
			url:'php/process_login.php',
			type:'post',
			data:data,
			dataType:'json',
			success:function(r) {
				console.log("hello world");
				window.location="teacher.php";
			}
		});
		return false;
	});
}
function processSignup(){
	$("#signup").submit(function() {
		var data={};
		var isEmpty=0;
		$("#signup input").each(function(k,v) {
			if(!$(v).val().length){
				isEmpty++;
				return false;
			}
			data[$(v).attr('name')]=$(v).val();
		})
		if(isEmpty) return false;
		if($("#signup input[name=password]").val() != $("#signup input[name=password2]").val()) {
	      alert("password mismatch");
	      return false;
	    }
	    if($("#signup input[name=password]").val().length < 6) {
	      alert("short password");
	      return false;
	    }

	    $.ajax({
	    	url:'php/process_signup.php',
	    	type:'post',
	    	data:data,
	    	dataType:'json',
	    	success:function(r) {
	    		console.log(r);
	    	}
	    });
		return false;
	});
}