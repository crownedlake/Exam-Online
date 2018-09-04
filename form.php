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
			echo "<script type=\"text/javascript\">alert(\"adf\");</script>";
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