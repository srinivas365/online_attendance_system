<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="css/style.css"/>
  <title>Student Attendance</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/c3.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!--<script src="js/highcharts.js"></script>
  <script src="js/highcharts-exporting.js"></script>-->
  <script src="js/jquery.knob.js"></script>
  <script src="js/student.js"></script>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
<!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Online Attendance</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.php">Home</a></li>
          </ul>
        </div>
      </div>
    </nav></br></br></br></br></br></br></br></br></br>
    <div class="container">
    	<div class="output" id="output">
    		<form id="getAttendance">
    			<div class="form-group">
      				<label>Year of course</label>
      				<select name="year" class="form-control">
       					 <?php foreach(range(date('Y',time()),1983) as $r) echo '<option>'.$r.'</option>'; ?>
      				</select>
    			</div>
    			<div class="form-group">
      				<label>Subject Code of Course</label>
      				<input type="text" class="form-control" name="code" placeholder="Eg - ICS212">
      			</div>
      			<div class="form-group">
      				<label>Roll Number</label>
      				<input type="text" name="roll" class="form-control" placeholder="Eg- 2016BCS0021">  
      			</div>
      			<button class="btn btn-primary">Get Results</button>
    		</form>
    	</div>
    	<div id="myDiv" class="container"><!-- Plotly chart will be drawn inside this DIV --></div>
    </div>
    <br>
    <br>
    <br>
</body>
</html>
<script type="text/javascript">
	function plotu(x_val,y_val) {
		// body...
		console.log("hello world from plotu");
		var plot_data = [
	  		{
	    		x: x_val,
  				y: y_val,
  				type: 'bar'
	  		}
		];
		Plotly.newPlot('myDiv', plot_data);
	}
</script>