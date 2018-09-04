<?php
// get the q parameter from URL
$subject = $_REQUEST["q"];	
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

		$sql = "SELECT chapters FROM subjects where subjectname='$subject'";
		$result = $conn->query($sql);

		if ($result->num_rows != 0) {
			while($row = $result->fetch_assoc()) {
				echo $row["chapters"];
			}
		} else {
			echo "0 results";
		}

		$conn->close();
?>