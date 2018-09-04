<?php
// get the q parameter from URL
$category = $_REQUEST["q"];
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

		$sql = "SELECT subjects FROM category where categoryname='$category'";
		$result = $conn->query($sql);

		if ($result->num_rows != 0) {
			while($row = $result->fetch_assoc()) {
				echo $row["subjects"];
			}
		} else {
			echo "0 results";
		}

		$conn->close();
?>