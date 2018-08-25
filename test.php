<?php
	session_start();
	echo $_SESSION['teacher_id'];
	print_r($_SESSION);
	$con = new mysqli("localhost","root","","attendance");
	$email=$_SESSION['email'];
	$exists = $con->query("SELECT * from teacher where email = '$email'");
	$exists = $exists->fetch_assoc();
	$_SESSION['name'] = $exists['name'];
	$_SESSION['email'] = $exists['email'];
	$_SESSION['phone'] = $exists['phone'];
	$_SESSION['teacher_id'] = $exists['uid'];
	$_SESSION['classes'] = 0;
	$teacher_uid=$_SESSION['teacher_id'];
	$classes = $con->query("SELECT uid from objects_test where teacher_uid = '$teacher_uid'");
	if($classes && $con->affected_rows) {
		$cls = array();
		while($a = $classes->fetch_array()) {
		  $cls[] = $a[0];
		} 
		$_SESSION['classes'] = $cls;
	}
	#print_r($cls);
	print_r($_SESSION);
	$con->close();
	session_write_close();
?>