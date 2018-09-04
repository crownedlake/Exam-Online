<!DOCTYPE html>
<html lang="en">
<head>
  <title>ExamOnline</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
[class*="col-"]{
	padding:3%;
}

.success{
	color: green;
	font-weight:bold;
}
.error{
	color: red;
	font-weight:bold;
}
#ques{
	background-color: #fffcea;
}
#top{
background-color: black;
}
#options{
	background-color: yellow;
}
#right{
	background-color: #fffcea;
	height: 71vh;
}
#left{
	background-color: yellow;
	width:100%;
	height: 71vh;
}
}
</style>
</head>
	<?php 

	$questionErr = $optionErr=$ansErr=$checkErr="";
	$question  = $check=$status="";
	$option = array();
	
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "examonline";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}  

	$sql = "SELECT categoryname from category";
	$result = $conn->query($sql);

	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

							
	  if (empty($_POST["question"])) {
		$questionErr = "*Question is required";
	  } else {
		$question = $_POST["question"];
	  }
	   if (empty($_POST["optradio"])) {
			$checkErr = "*Please Select one option";
		} else {
			$check =$_POST["optradio"];
		}
	  
	 
	  for($i=0;$i<4;$i++)
	  {
		  $y=$i+1;
		  if (empty($_POST["op$y"])) {
		$optionErr = "*Options are required";
	  } else {
		$option[$i] = $_POST["op$y"];
	  }
	  }

	 if($questionErr == $optionErr)
	 {
		$option[2] = $_POST["op3"];
		$option[3] = $_POST["op4"];
		$sql = "INSERT INTO questions (question,op1,op2,op3,op4,answer)
		VALUES ('$question', '$option[0]', '$option[1]', '$option[2]', '$option[3]','$check')";

		if ($conn->query($sql) === TRUE) {
			$status= "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
	 }

	}

	?>
<body background="back.png">
	<div class="container">
		<div class ="row" >
			<div class="col-sm-12" id="top"><h1>ExamOnline</h1></div>
		</div>
		<div class="row" >
		
			<div class="col-sm-3" id="options" id="row1">
			<form id="categoryform" method="post" action="index.php" >
			<div id="left">

				<div class="col-sm-8">
					<label for="category">Category</label>
					<select class="form-control" id="category">
					<option> - </option>
					</select>
				</div>
				  
				<div class="col-sm-8">
					<label for="subject">Subject</label>
					<select class="form-control" id="subject">
					<option> - </option>
					</select>
				</div>
				
				<div class="col-sm-8">
					<label for="chapter">Chapter Name</label>
						<select class="form-control" id="chapter">
					<option> - </option>
						</select>
				</div>
			</div>
			</div>
		<div class="col-sm-9" id="ques">
		<div id="right">
		<form class="form-horizontal" id="myForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
		<span class="help-block">Type your question and options and select the Correct option before adding.</span>
			<div class="form-group" >
				<div class="col-sm-6">
				<textarea class="form-control" id="focusedInput" name="question" placeholder="Enter Your Question "rows="5"  ><?php echo $question;?></textarea>
				<span class="error"> <?php echo $questionErr;?></span>
				</div>    
			</div>
			
			<div class="col-sm-3">
				<label class="radio">
				<input type="radio" name="optradio" id="option1"  value="1">  <input class="form-control" type="text" placeholder="Option 1"  name="op1"> 
				</label>
				<label class="radio">
				<input type="radio" name="optradio" id="option2"  value="2">  <input class="form-control"  type="text" placeholder="Option 2" name="op3">
				
				</label>
			</div>
			<div class="col-sm-3">
				<label class="radio">
				<input type="radio" name="optradio" id="option3"  value="3">  <input class="form-control"  type="text" placeholder="Option 3" name="op2">
				</label>
				<label class="radio">
				<input type="radio" name="optradio" id="option4"  value="4">  <input class="form-control"  type="text" placeholder="Option 4" name="op4">
				</label>
			</div> 
			<div class="col-sm-5">
			<br><br>
			<span class="error"> <?php echo $optionErr;?></span><br>
			<span class="error"> <?php echo $checkErr;?></span>	
			<span class="success"> <?php echo $status;?></span>	
			</div>
			<div class="col-sm-10">
				<button type="submit" id="addQues" class="btn btn-primary" >Add Question</button>
				<button type="submit" name="submit"  class="btn btn-primary" >Submit</button>
			</div>
	  </form>
		</div>
		</div>
		
		</div>
	</div>
	<?php
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				showCategory($row["categoryname"]);
			}
		} else {
			echo "0 results";
		}
		function showCategory($data){
		echo "<script>
		var div = document.getElementById(\"category\");
		var myData = div.textContent;
		var para = document.createElement(\"option\");
		var t = document.createTextNode(\"$data\");
		para.appendChild(t);
		document.getElementById(\"category\").appendChild(para);
		</script>";
	}
	?>

	<script>
	
	
	$('#category').change(function() {
		var div = document.getElementById("subject");
		div.innerHTML="<option> - </option>";
		var val = $("#category option:selected").text();
		var xhttp;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var cat=this.responseText;
			var str=cat.split(',');
			for(var i=0;i <str.length;i++)
			{
				var para = document.createElement("option");
				var t = document.createTextNode(str[i]);
				para.appendChild(t);
				document.getElementById("subject").appendChild(para);
			}
		}
	};
	xhttp.open("GET", "dynamic.php?q="+val, true);
	xhttp.send();
	});
	
	$('#subject').change(function() {
		var div = document.getElementById("chapter");
		div.innerHTML="<option> - </option>";
		var val = $("#subject option:selected").text();
		var xhttp;
		xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var cat=this.responseText;
			var str=cat.split(',');
			for(var i=0;i <str.length;i++)
			{
				var para = document.createElement("option");
				var t = document.createTextNode(str[i]);
				para.appendChild(t);
				document.getElementById("chapter").appendChild(para);
			}
		}
	};
	xhttp.open("GET", "dynamic2.php?q="+val, true);
	xhttp.send();
	});
	</script>
</body>
</html>