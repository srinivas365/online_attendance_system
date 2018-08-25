<?php
session_start();
$isIndex=0;
if(!(array_key_exists('teacher_id', $_SESSION)) && isset($_SESSION['teacher_id'])){
	session_destroy();
	if(!$isIndex) header('Location : index.php');
}
?>
<?php include 'php/node_class.php';?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>