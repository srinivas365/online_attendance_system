$(document).ready(function() {
	$('#cancel').click(function(){
		$('.modal').modal('hide');
	});
	$('#add').click(function(){
		addTheClass();
	})
	$('.delete-class-warning').click(function() {
		deleteWarning($(this).parent());
	})
	$('delete-class-code').click(function() {
		deleteClass($(this).parent());
	})
})

function deleteWarning(handle){
  code = handle.find('.code').text();
  year = handle.find('.year').text();
  $('.warning-class').html('<span class="warning-code">'+code+'</span> ) '+' , <span class="warning-year">'+year+'</span>');
}
function deleteClass(handle){
	
}
function addTheClass(){
	var fields=$('#add_class_form input,#add_class_form select');
	var data={};
	for(i=0;i<fields.length;i++){
		data[jQuery(fields[i]).attr('name')]=jQuery(fields[i]).val();	
	}
	console.log(data);

	$.ajax({
		url:'php/add_class.php',
		type:'POST',
		data:data,
		dataType:'json',
		success : function (r) {
			console.log(r);
	      if(r.error == 'code') {
	        alert('Invalid Code!');
	        $('input[name=code]').val('');
	        return;
	      }
	      if(r.error == 'year') {
	        alert('Invalid Year!');
	        $('input[name=year]').val('');
	        return;
	      }
	      
	      if(r.error == 'semester') {
	        alert('Invalid Semester!');
	        $('input[name=semester]').val('');
	        return;
	      }
	      if(r.error == 'roll') {
	        alert('Invalid Starting/Ending Roll Number!');
	        $('input[name=end],input[name=start]').val('');
	        return;
	      }
	      if(r.error == 'exists') {
	        alert('This class is already added!');
	        $('input[name=code]').val('');
	        return;
	      }
	      $('.wrapper').prepend('<div class="class"> <a class="no-decoration" href="take.php?cN='+r.class_id+'"> <div><strong>Code</strong> : <span class="code">'+r.code+'</span></div> <div><strong>Year</strong> : <span class="year">'+r.year+'</span> </div> <div><strong>Classes</strong> : 0</div> </div></a>');
	      $('.wrapper .class').first().hide();
	      $('.wrapper .class').first().show('slow');
	      $('.modal').modal('hide');
	      $('.no-classes').remove();
	    }, 
	    error : function (err) {
	      console.log(err);
	    }   
	})


}