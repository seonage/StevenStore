<?php

session_start();

// ensures no one can directly access this page. People who try to access this page without logging in will be re-directed to login page

if (isset($_SESSION['adminUser']))
{
	echo "<p>You are logged in as: ".$_SESSION['adminUser']."</p>";
}
	
else if (isset($_SESSION['managerUser']))
{
	echo "<p>You are logged as: ".$_SESSION['managerUser']."</p>";
}

else
{
	header('Location: index.php');
}

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$getUserType = "SELECT DISTINCT Type FROM Users";
$getUserTypeQuery = $connecting->query($getUserType);

if (!$getUserTypeQuery)
{
	echo "<p>Could not query database</p>";
}

$numTypes = @ $getUserTypeQuery->num_rows;

if ($numTypes == 0)
{
	echo "<p>No users were found</p>";
}

$typeArray = array();

for ($count = 0; $row = $getUserTypeQuery->fetch_assoc(); $count++)
{
	$typeArray[$count] = $row;
}

foreach ($typeArray as $row)
{
	$url = "http://codd.cs.montclair.edu/~lins/deleteUser.php?userType=".($row['Type']);
	$title = $row['Type'];
	echo "<a href=$url>$title</a></br>";
}

if ($userType = $_GET['userType'])
{
	$userArray = array();
	$userInfo = "SELECT Email, FirstName, LastName FROM Users WHERE Type = '$userType'";
	$userInfoQuery = $connecting->query($userInfo);
	
	for ($count = 0; $row = $userInfoQuery->fetch_assoc(); $count++)
	{
		$userArray[$count] = $row;
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
	
	foreach ($userArray as $row)
	{
		$userEmail = $row['Email'];
		$userFirstName = $row['FirstName'];
		$userLastName = $row['LastName'];
		$url = "http://codd.cs.montclair.edu/~lins/deleteUser.php?email="."$userEmail";
		
		echo "<tr>
		<td>$userEmail</td>
		<td>$userLastName</td>
		<td>$userFirstName</td>
		<td><a href = $url>Delete</a></td>
		</tr>";
	}
	
	echo "</table>";
}

if ($email = $_GET['email'])
{
	$deleteUser = "DELETE FROM Users Where Email = '$email'";
	$deleteUserQuery = $connecting->query($deleteUser);
	
	if ($deleteUserQuery == true)
	{
		echo "<p>The user has been deleted</p>";
	}
	
	else
	{
		echo "<p>Error: User was not deleted</p>";
	}
}

//makes sure that the user returns to correct previous page. For example, someone logged in as an admin should return to the admin
//page not the manager page
if (isset($_SESSION['adminUser']))
{
	echo "<p><a href = admin.php>Return to previous page</a></p>";
}

if (isset($_SESSION['managerUser']))
{
	echo "<p><a href = manager.php>Return to previous page</a></p>";
}

?>