$(document).ready(function(){
if(gup('roll') && gup('code') && gup('year')) {
    $("#getAttendance select[name=year]").val(gup('year'));
    $("#getAttendance input[name=code]").val(gup('code'));
    $("#getAttendance input[name=roll]").val(gup('roll').replace(/-/g,"/"));
    getAttendance();
  }
	$("#getAttendance").submit(function(){
		getAttendance();
		return false;
	});
});
function checkGets(url){
	var field1='roll';
	var field2='code';
	var field3='year';
	if(url.indexOf('?'+field1+'=')!=-1 && url.indexOf('&'+field2+'=')!=-1 && url.indexOf('&'+field3+'=')!=-1){
		return true;
	}
}
function getAttendance(){
	var data=getFormElements("#getAttendance");
	var check=0;
	jQuery.each(data,function(k,v){
		console.log(k+":"+v);
		if(v==''){
			check++;
		}
	});
	if(check){
		$('#output').html("<h2> Fill all details! </h2>");
    	return;
	}
	$.ajax({
		url:'php/get_attendance.php',
		type:'post',
		data:data,
		dataType:'json',
		success:function(r){
			console.log(r);
			if(r.error == 'NO_RECORD') {
				$('#output').html('<h2> No records found for this class!</h2>');
				return;
			} else if(r.error == 'NOT_IN_RECORDS') {
				$('#output').html('<h2> This roll number doesn\'t belong to this class! </h2>');
				return;
			} else if(r.error == 'DB_ERROR') {
				$('#output').html('<h2> We are facing issues at backend! </h2>');
				return;
			} else { 
				$('#output').html("<h1> Teacher : "+r.teacher['name']+"</h1><h4>Subject : "+$('input[name="code"]').val()+"</h4><h4>Total Classes : "+r.count+"</h4><div id='chart'></div><div id='pie'></div>");
				generateGraph(r.timeline);
				$('#pie').html('<h2>Percent : </h2> <input class="knob" value="'+(Math.floor(r.percent))+'" data-readonly="true" data-thickness=".4" readonly="readonly" data-width="150" data-height="150" data-angleOffset=180 data-fgColor="#87AB66" data-bgColor="#E1EAD9">');
				loadKnob();
				return;
			}
		},	
		error:function(xhr, status, error) {
  			var err = eval("(" + xhr.responseText + ")");
  			console.log(err.Message);
		}					
	})
}
function getFormElements(formId){
	var data={};
	$(formId+' input,'+formId+' select,'+formId+' textarea').each(function(k,v){
		data[$(this).attr('name')]=$(this).val();
	});
	console.log(data);
	return data;
}
function generateGraph(data){

	x_values=$.map(data,function(v,k){
		return new Date(1000*k).toDateString();
	});
	y_values=$.map(data,function(v,k){
		return v;
	});
	console.log(x_values);
	console.log(y_values);
	plotu(x_values,y_values);
}

function gup( name ){
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return results[1];
}