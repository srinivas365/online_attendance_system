<?php session_start();?>
<?php include 'node_class.php';?>
<?php
$teacher_id=$_SESSION['teacher_id'];
$code=$_POST['code'];
$year=$_POST["year"];
$semester=$_POST["semester"];
$classes = $_SESSION['classes'] == 0?array():$_SESSION['classes'];

$n = new Node($code,$teacher_id,$year,$semester) or respond("error","exists");
updateSession($_SESSION['email']);
$classes2 = $_SESSION['classes'];
$class_id;
foreach($classes2 as $c) {
if(!in_array($c,$classes)) $class_id = $c;
}
if(!isset($class_id)) respond("error","exists");
echo json_encode(array("code"=>$code,"year"=>$year,"class_id"=>$class_id));
?>