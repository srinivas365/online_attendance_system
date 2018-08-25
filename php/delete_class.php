<?php
session_start();
include 'node_class.php';
$code=$_POST['code'];
$year=$_POST['year'];
$classNode=new Node;
$node=$classNode->retrieveObject($code) or respond("error","not_found");
if($node->getTeacherID() == $_SESSION['teacher_id']) {
    if($node->deleteNode()) {
      updateSession($_SESSION['email']);
      respond("error","none");
    }
    respond("error","failure");
  }
  respond("error","illegal");
?>