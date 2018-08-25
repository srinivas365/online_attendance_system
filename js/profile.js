$(document).ready(function(){
	$('.update-profile').hide();
	$('.update-profile').click(function(){
		updateProfile($(this));
	});
	$('input[name=name], input[name=phone], input[name=email]').on('keyup',function(){
		$('.update-profile').slideDown('fast');
	});
})
function updateProfile(a){
	var name = $('input[name=name]').val() == null?'':$('input[name=name]').val();
  	var phone = $('input[name=phone]').val() == null?'':$('input[name=phone]').val();
  	var email = $('input[name=email]').val() == null?'':$('input[name=email]').val();
  	$.ajax({
    url : 'php/update_profile.php',
    type : 'post',
    data : {name:name,phone:phone,email:email},
    dataType : 'json',
    success : function(r) {
      switch(r.error) {
        case 'phone' : alert("Invalid Phone!"); break;
        case 'email' : alert("Invalid Email!"); break;
        case 'name' : alert("Invalid Name!"); break;
        case 'exists' : alert("This email id is already in use!"); break;
        case 'none' : a.html('Saved!'); setTimeout(function() { window.location = ""; },500); break;
        case 'not_found' : case 'failure' : 
        alert("We are facing some troubles at out server side. Logging you out for security");
        window.location = "logout.php";
      }
    }  
  });
}