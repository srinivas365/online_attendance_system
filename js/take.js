$(document).ready(function() {
	console.log('hello world');
	$('.marker').on('click',function(){
		markAsPresent($(this));
	});
	$('#submit').on('click',function(){
		submitData();
	});
	$(".roll").tooltip({title:'Click to see history',placement:'top'});
  	$(".present").tooltip({title:'This is the number of days the student has attended your classes',placement:'top'});
  	$(".marker").tooltip({title:'Click to mark this student as present or absent',placement:'top'});

});
function submitData(){
	var data=[];
	var time=Math.round((new Date).getTime()/1000);
	$('.student-record').each(function(k,v){
		var d={
			roll:$(this).find('.roll').text(),
			newpresent:$(this).find('.present').text(),
			timestamp:time
		};
		data.push(d);
	})
	console.log(data);
	$.ajax({
		url:'php/mark_attendance.php',
		type:'post',
		data:{content:data,class_id:class_id,teacher_id:teacher_id},
		dataType:'json',
		success:function(r){
			console.log(r);
			if(r.error == 'none') {
		        $('#submit').html('Saved!');
		        $('#studentRecords').hide('slow',function() {
		          $('#studentRecords').html('<h2> Saved! Redirecting you to home page </h2>');
		        });
		        $('#studentRecords').show('fast',function () {
		          setTimeout(function() {
		            window.location = "teacher.php";
		          },1500);
		        });
      		}
		},
		error: function(xhr, status, error) {
  				var err = eval("(" + xhr.responseText + ")");
  				console.log(err.Message);
			}
	});
}
function markAsPresent(marker){
	markerParent=marker.parent();
	present=markerParent.find('.present');
	numPresents=parseInt(present.text());
	if(marker.text()=='A'){
		marker.html('P');
		marker.css('font-weight','bold');
		marker.addClass('btn-success');
		present.html(numPresents+1);
	}else{
		marker.css('font-weight','');
		marker.html('A');
		marker.removeClass('btn-success');
		present.html(numPresents-1);
	}
}