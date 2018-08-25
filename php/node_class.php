<?php
require_once('defines.php');

class Node{
  private $teacher;
  private $code;
  private $year;
  private $semester;
  private $numberOfDays;
  private $records=array();

  function __construct(){
    $a=func_get_args();
    $i=func_num_args();
    if(method_exists($this,$f='__construct'.$i)){
      call_user_func_array(array($this,$f),$a);
    }
  }

  function __construct4($code,$teacher_uid,$year,$semester){
    $this->setCode($code);
    $this->setTeacher($teacher_uid);
    $this->setYear($year);
    $this->setSemester($semester);
    $this->setDays(0);
    $this->initRecords($code,$semester);  //this is the function which grabs all students who opted this class when class created
    if($this->saveNode()===false){
      echo false;
    }
  }
  public function setCode($code){
    $this->code=$code;
  }
  public function setTeacher($value)
  {
    $this->teacher=$value;
  }
  public function setYear($value)
  {
    $this->year=$value;
  }
  public function setSemester($value)
  {
    $this->semester=$value;
  }
  public function setDays($value)
  {
    $this->numberOfDays=$value;
  }
  public function getTeacherID(){
    return $this->teacher;
  }
  public function getCode(){
    return $this->code;
  }
  public function getDays(){
    return $this->numberOfDays;
  }
  public function getYear(){
    return $this->year;
  }
  public function getSemester(){
    return $this->semester;
  }
  public function getRecords(){
    return $this->records;
  }
  public function getTeacherName(){
    $teacher_id=$this->getTeacherID();
    $con=connectTo();
    $s=$con->query("SELECT name from teacher where uid='$teacher_id'");
    $name=$s->fetch_assoc();
    return $name;
  }
  public function getTimeline($rollNumber){
    return isset($this->records[$rollNumber])?$this->records[$rollNumber]['timeline']:false;
  }
  
  public function addRoll($roll){
    if(!isset($this->records[$roll])){
      $this->records[$roll]=array('present'=>0,'timeline'=>array());
      $this->saveNode();
    }
  }
  public function deleteRoll($rollNumber){
    if(isset($this->records[$rollNumber])){
      unset($this->records[$rollNumber]);
      return true;
    }
    return false;
  }

  public function initRecords($code,$semester){
    $conn = mysqli_connect("localhost", "root", "", "company");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM user_details where semester='$semester' ";  //query to grab all students who opted this class
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $a=$row['email_id'];
            $this->records[$a] = array('present'=>0,'timeline'=>array());
        }
    } else {
        echo "0 results";
    }
    mysqli_close($conn);
  }

  public function saveNode(){
    $con=new mysqli("localhost","root","","attendance");
    if($con->connect_error){
      die("connection failed".$con->connect_error);
    }
    $teacher_uid=$this->getTeacherID();
    $code=$this->getCode();
    $year=$this->getYear();
    $serialize_object=$con->real_escape_string(serialize($this));
    $sql="SELECT object from objects_test where teacher_uid='$teacher_uid' and code='$code' and year='$year'";
    $obj=$con->query($sql);
    if($obj->num_rows){
      $obj=$con->query("UPDATE objects_test set object='$serialize_object' where teacher_uid='$teacher_uid' and code='$code' and year='$year'");
    }else{
      $obj=$con->query("INSERT into objects_test(teacher_uid,code,year,object) values('$teacher_uid','$code','$year','$serialize_object')");
      if($con->errno){
        return false;
      }else{
        return true;
      }
    }
    return false;
  }


  public function retrieveObject($class_id,$year){
    $con=new mysqli("localhost","root","","attendance");
    if($con->connect_error){
      die("unable to connect ".$con->connect_error);
    }
    $sql="SELECT object from objects_test where code='$class_id' and year='$year'";
    $obj=$con->query($sql);
    if($con->errno){
      return false;
    }else{
      if($obj->num_rows==1){
        $obj=$obj->fetch_assoc()['object'];
        return unserialize($obj);
      }else{
        return false;
      }
    }
  }
  public function getObjectByUid($uid){
    $con=new mysqli("localhost","root","","attendance");
    if($con->connect_error){
      die("unable to connect ".$con->connect_error);
    }
    $sql="SELECT * from objects_test where uid=$uid";
    $obj=$con->query($sql);
    if($con->errno){
      return false;
    }else{
      if($obj->num_rows==1){
        $obj=$obj->fetch_assoc()['object'];
        return unserialize($obj);
      }else{
        return false;
      }
    }
  }

  public function isPresent($rollNumber,$newPresents){
    if(isset($this->records[$rollNumber])){
      return ($this->records[$rollNumber]['present']<$newPresents)?1:0;
    }
    return false;
  }
  public function setPresence($rollNumber,$newPresents,$timestamp){
    if(isset($this->records[$rollNumber])){
      $this->records[$rollNumber]['timeline'][$timestamp]=$this->isPresent($rollNumber,$newPresents);
      $this->records[$rollNumber]['present']=$newPresents;
    }else{
      return false;
    }
  }
  public function getPercent($rollNumber){
    return isset($this->records[$rollNumber])?(100*($this->records[$rollNumber]['present']/$this->getDays())):false;
  }
  
}

#$a=new Node('IMS212',6,2016,1);
#print_r($a);
?>