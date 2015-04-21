<?php

session_start();

// ensures no one can directly access this page. People who try to access this page without logging in will be re-directed to login page
if (!isset($_SESSION['adminUser']))
{
	header('Location: index.php');
}
else
{
	echo '<p>You are logged in as: '.$_SESSION['adminUser'].'</p>';
}

echo "<h2>Please select what type of employee you wish to modify</h2>";

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$typeQuery = "SELECT DISTINCT Type from Users";
$typeQueryResult = $connecting->query($typeQuery);

if ($typeQueryResult == false)
{
	echo "<p>Could not query database</p>";
}

$numTypes = $typeQueryResult->num_rows;

if ($numTypes == 0)
{
	echo "<p>No employee types were found</p>";
}

$typeArray = array();

for ($count = 0; $row = $typeQueryResult->fetch_assoc(); $count++)
{
	$typeArray[$count] = $row;
}

foreach ($typeArray as $row)
{
	$url = "http://codd.cs.montclair.edu/~lins/modifyUser.php?type=".($row['Type']);
	$title = $row['Type'];
	Echo "<a href=$url>$title</a></br>";
}

if ($employeeType = $_GET['type'])
{
	echo "<h2>Select the employee you would like to modify:</h2>";
	
	$employeeArray = array();
	$employeeQuery = "SELECT Email, FirstName, LastName FROM Users WHERE Type = '$employeeType'";
	$employeeQueryResult = $connecting->query($employeeQuery);
	
	for ($count = 0; $row = $employeeQueryResult->fetch_assoc(); $count++)
	{
		$employeeArray[$count] = $row;
	}
	
	echo "<table = border=\"0\" width = 50% cellspacing=\"0\">
	<thead>
	<tr bgcolor = #cccc99>
	<th align = \"left\">Email</th>
	<th align = \"left\">Last Name</th>
	<th align = \"left\">First Name</th>
	<th align = \"left\"></th>
	</tr>
	</thead>";
	
	foreach ($employeeArray as $row)
	{
		$userEmail = $row['Email'];
		$userFirstName = $row['FirstName'];
		$userLastName = $row['LastName'];
		$url = "http://codd.cs.montclair.edu/~lins/newUserInformation.php?email="."$userEmail";
		
		echo "<tr>
		<td>$userEmail</td>
		<td>$userLastName</td>
		<td>$userFirstName</td>
		<td><a href = $url>Modify</a></td>
		</tr>";
	}
	
	echo "</table>";
}

?>

<p><a href = admin.php>Return to previous page</a></p>