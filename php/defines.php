<?php
DEFINE('DB_USER','root');
DEFINE('DB_PASS','');
DEFINE('DB_HOST','localhost');
DEFINE('DB_DB','attendance');
DEFINE('EMAIL',1);
DEFINE('PHONE',2);
DEFINE('ROLL',3);
DEFINE('CODE',4);
DEFINE('NAME',5);
DEFINE('NUMBER',6);
function connectTo() {
/*
 Does -> Connects to data base
 Returns -> Connection object
*/
  $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_DB);
  return $con;   
}
function sqlReady($input) {
/*
 Takes -> Any string
 Returns -> Escapes the string
*/
  $con = connectTo();
  $string = mysqli_real_escape_string($con,$input);
  $con->close();
  return $string; 
}

function hashPass($pass,$rounds = 9) {
/*
 Takes -> Password
 Returns -> Hashes the password using blow-fish algorithm
*/
  $salt = "";
  $i = -1;
  $saltChars = array_merge(range(0,9),range('a','z'),range('A','Z'));
  while(++$i < 22)
    $salt .= $saltChars[array_rand($saltChars)];
  return crypt($pass, sprintf('$2y$%02d$', $rounds) . $salt);
}
function verifyPass($input,$pass) {
/*
 Takes -> 2 Password strings
 Returns -> true if matches false if doesn't
*/
  return crypt($input,$pass) == $pass? true : false ;
}
function respond($as,$what) {
/*
 Takes -> key and value
 Does -> Dies by printing json_encoded array having the key and value
*/
  die(json_encode(array($as=>$what)));
}

function updateSession($email) {
/*
 Takes -> email
 Does -> Updates the SESSION variable as per the email
*/
  $con = connectTo();
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
  $con->close();
  session_write_close();
}
?>
