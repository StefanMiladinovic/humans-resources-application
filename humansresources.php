<!DOCTYPE html>
<html>

<!--

PHP Developer: Stefan Miladinovic (Contact: st.miladinovic187@gmail.com)

No part of this publication may be reproduced, distributed, without the prior written permission of the publisher!
This PHP file is for educational purposes. 
!!! Do not delete copyrights without permission !!!

-->

<title>Human's Resources</title> <!-- Change title -->

<style>
body {
	background-color: #f0f0f0;
}
#myHeader {
    background-color: grey;
    color: white;
    padding: 30px;
    text-align: left;
}
</style>

<body>

<h1 id="myHeader">Humans Resources Application</h1> <!-- Header -->

<?php
	// Database informations
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "humanres";
	
	// Connecting to server
	$conn = new mysqli($servername, $username, $password);
	
	// Creates database (dbname) if base doesn't exist
	$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
	if ($conn->query($sql) === TRUE) { } else { echo "<p style='color:red'>Error creating database: " . $conn->error . "</p>"; }
	
	// Connecting to database
	$conn = new mysqli($servername, $username, $password, $dbname);
	echo "<p style='color:green'>Successfully connected to database (server name: $servername, database: $dbname, username: $username)</p>";
	if ($conn->connect_error) { echo "<p style='color:red'>Database connection failed: " . $conn->connect_error . "</p>"; }
	
	// Creates table (users) if table doesn't exist
	$sql = "CREATE TABLE IF NOT EXISTS users (id INT(2) UNSIGNED AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, telephone INT(15) NOT NULL, inum INT(4) NOT NULL, reg_date TIMESTAMP)";
	if ($conn->query($sql) === TRUE) { } else { echo "<p style='color:red'>Error creating table: " . $conn->error . "</p>"; }
	
    $conn->close();
    
    //Random Quotes Function
	$x = (rand(1,3));
	
	if($x == 1)
	{
		echo "<p>Lawrence Bossidy:</p>"; 
		echo "<blockquote>";
		echo "<i>Nothing we do is more important than hiring people. At the end of the day, you bet on people, not strategies.</i>";
		echo "</blockquote>";
	}
	else if($x == 2)
	{
		echo "<p>Meghan Biro:</p>";
		echo "<blockquote>";
		echo "<i>Employees engage with employers and brands when they are treated as humans.</i>";
		echo "</blockquote>";
	}
	else if($x == 3)
	{
		echo "<p>Julie Bevacqua:</p>";
		echo "<blockquote>";
		echo "<i>In order to build a rewarding employee experience, you need to understand what matters most to your people.</i>";
		echo "</blockquote>";
	}
	
?>

<script>
// Script allows only numbers in text (inputtext)
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>

<!-- 
Firstname Input (name:firstname)
Lastname Input (name:lastname)
Telephone Input (name:telephone)
In. Number Input (name:inum)

Delete Input (name:deleteinum)

Inser Button (name:button_1)
Deleteuser Button (name:button_2)
Refresh Button (name:button_3)
-->

<br><br>
<form method="post">
  Firstname: <input type="text" name="firstname" style="text-transform: capitalize;" pattern="[a-zA-Z]{1,}"/>
  &emsp;&emsp;&emsp;&emsp;Delete user record (type in.number): 
  <input type="text" name="deleteinum" maxlength="4" onkeypress="return isNumberKey(event)"/><br><br>
  Lastname: <input type="text" name="lastname" style="text-transform: capitalize;" pattern="[a-zA-Z]{1,}"/>
  &emsp;&emsp;&emsp;&emsp;
  <input value="Delete user" name="button_2" type="submit"></input><br><br>
  Telephone: <input type="text" name="telephone" onkeypress="return isNumberKey(event)"/><br><br>
  In.Number: <input type="text" name="inum" maxlength="4" onkeypress="return isNumberKey(event)"/>&emsp;&emsp;&emsp;&emsp;<input value="Refresh Page and Database" name="button_3" type="submit"></input><br><br>
  <input value="Insert user in database" name="button_1" type="submit"></input>
</form>

<?php

if(isset($_POST["button_3"])) // button_3 click event (refresh page)
{
	header("Refresh:0");
}

if(isset($_POST["button_2"])) // button_2 click event (delete user)
{
	if(trim($_POST["deleteinum"]) == '')
	{
		echo "<br><p style='color:red'>You did not fill out the required fields.</p>";
	}
	else
	{	
		$inum = $_POST['deleteinum'];
		
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = "SELECT inum FROM users WHERE inum='$inum'";
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) 
		{
			$conn = new mysqli($servername, $username, $password, $dbname);
			$sql = "DELETE FROM users WHERE inum=$inum";
			if ($conn->query($sql) === TRUE) 
			{
				echo "<br><p style='color:green'>Record (In.Num: $inum) deleted successfully!</p>";
			} 
			else 
			{
				echo "<p style='color:red'>Error deleting record: " . $conn->error . "</p>";
			}
		}
		else
		{
			echo "<br><p style='color:red'>That user does not exist!</p>";
		}
		
		$conn->close();
	}
}

if(isset($_POST["button_1"])) // button_1 click event (creates new record)
{
	if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['telephone']) && isset($_POST['inum']))
	{
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$telephone = $_POST['telephone'];
		$inum = $_POST['inum'];
		
		if(trim($firstname) == '' || trim($lastname) == '' || trim($telephone) == '' || trim($inum) == '')
		{
		   echo "<br><p style='color:red'>You did not fill out the required fields.</p>";
		}
		else if(strlen($firstname) > 30){echo "<p style='color:red'>Firstname can have maximum length of 30 characters.</p>";}
		else if(strlen($lastname) > 30){echo "<p style='color:red'>Lastname can have maximum length of 30 characters.</p>";}
		else if(strlen($telephone) > 15){echo "<p style='color:red'>Telephon number can have maximum length of 15 digits.</p>";}
		else
		{		
			$conn = new mysqli($servername, $username, $password, $dbname);
			$sql = "SELECT inum FROM users WHERE inum='$inum'";
			$result = $conn->query($sql);
			
			if ($result->num_rows > 0)
			{
				echo "<p style='color:red'><br>That indetificational number already exists. Please contact your manager!</p>";
				$conn->close();
			}
			else
			{	
				$conn->close();
				$conn = new mysqli($servername, $username, $password, $dbname);
				$sql = "INSERT INTO users (firstname, lastname, telephone, inum) VALUES ('$firstname', '$lastname', '$telephone', '$inum')";
				 
				if ($conn->query($sql) === TRUE) {
				$last_id = $conn->insert_id;
				echo "<br><p style='color:green'>New record created successfully. Last inserted ID is: " . $last_id . "</p>";
				} else { echo "Error: " . $sql . "<br>" . $conn->error; }
				$conn->close();
			}
		}
	}
}
?>

<br><hr></hr>

<?php //Creates table with all users' informations

	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT * FROM users";
	$result = $conn->query($sql);

	if ($conn->connect_error) { echo "<p style='color:red'>Database connection failed: " . $conn->connect_error . "</p>"; }
	else
	{
		$sql = "SELECT * FROM users";
		echo "<br><table width='1000' border='3'> 
		<tr>
		<th style='text-align: left;'>Firstname</th>
		<th style='text-align: left;'>Lastname</th>
		<th style='text-align: left;'>Telephone</th>
		<th style='text-align: left;'>In.Number</th>
		<th style='text-align: left;'>Registration Date</th>
		</tr>";		
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['firstname'] . "</td>"; 
			echo "<td>" . $row['lastname'] . "</td>";
			echo "<td>" . $row['telephone'] . "</td>";
			echo "<td>" . $row['inum'] . "</td>";
			echo "<td>" . $row['reg_date'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		$conn->close();
	}
?>

<p style="text-decoration:none;bottom:0;left:10px;font-size:12pt;color:gray;position:absolute">Humans Resources Application | Copyright @ 2018 by Stefan Miladinovic</p>

</body>

</html>
