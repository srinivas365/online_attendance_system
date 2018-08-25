<?php
session_start();
if(array_key_exists('teacher_id',$_SESSION) && isset($_SESSION['teacher_id'])){
	header('Location:teacher.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/style.css"/>
  	<title>Student Attendance</title>
  	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/login.js"></script>
</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="index.php">Attendance Management System</a>
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li class="active"><a href="#">Home</a></li>
	            <li><a href="student.php">Student</a></li>
	            <li><a href="#contact">Contact</a></li>
	          </ul>
	        </div>
	      </div>
	    </nav>
	    <div class="container" style="margin-top: 50px;">
	    	<h2>Teacher dashboard</h2>
	    	<div class="alert alert-warning hidden">
	    		<span></span>
	    		<button type="button" class="close" onclick="$('.alert').addClass('hidden');">&times;</button>
	    	</div>
	    	<table class="table">
		    	<tbody>
		    		<tr>
		    			<td>
		    				<form id="login">
		    					<div class="form-group">
		    					<label>Email ID</label>
		    					<input type="email" name="email" placeholder="enter the email id" class="form-control">
		    					</div>
		    					<div class="form-group">
		    					<label>password</label>
		    					<input type="password" class="form-control" name="password">
		    					</div>
		    					<button class="btn btn-primary pull-right">Login</button>
		    				</form>
		    			</td>
		    			<td>
		    				<form id="signup">
		    					<div class="form-group">
		    						<div class="form-group">
						                <label>Name</label>
						                <input class="form-control" placeholder="Name" type="text" name="name">
						             </div>
					            <div class="form-group">
					                <label>Phone Number</label>
					                <input class="form-control" placeholder="Phone" type="text" name="phone">
					              </div>
					            <div class="form-group">
					                <label>Email ID</label>
					                <input class="form-control" placeholder="Email" type="email" name="email">
					              </div>
					            <div class="form-group">
					                <label>Password</label>
					                <input class="form-control" placeholder="Password" type="password" name="password">
					                <span class="help-block">Password should be 6 characters long.</span>
					              </div>
					            <div class="form-group">
					                <label>Re-type Password</label>
					                <input class="form-control" placeholder="Re-type Password" type="password" name="password2">
					            </div>
					              <button class="btn btn-primary pull-right">Sign Up</button>

							    </div>
		    				</form>
		    			</td>
		    		</tr>
		    	</tbody>
	    	</table>
	    </div>
	</body>
</html>