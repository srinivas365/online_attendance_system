<?php session_start(); ?>
<?php include 'defines.php';?>
<?php
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$teacher_id = $_SESSION['teacher_id'];
	if($name == $_SESSION['name'] && $phone == $_SESSION['phone'] && $email == $_SESSION['email'])
    respond("error","none");

  $name = sqlReady($name);
  $phone = sqlReady($phone);
  $email = sqlReady($email);
  
  $con = connectTo();
  $query = $con->query("SELECT email from teacher where email = '".$email."'");
  if($query && $con->affected_rows && $email != $_SESSION['email']) respond("error","exists");
  $query = $con->query("SELECT email from teacher where uid = '".$teacher_id."'");
  if($query && $con->affected_rows) {
    $q = "UPDATE teacher set ";
    if($name != '') $q .= "name = '".$name."'";
    if($email != '') $q .= ", email = '".$email."'";
    if($phone != '') $q .= ", phone = '".$phone."'";
    $q .= ' where uid = "'.$teacher_id.'"';
    $query = $con->query($q);
    if($query && $con->affected_rows) {
      if($name != '') $_SESSION['name'] = $name;
      if($email != '') $_SESSION['email'] = $email;
      if($phone != '') $_SESSION['phone'] = $phone;
      respond("error","none");
    }
    respond("error","failure");
  }
  respond("error","not_found");

?>