<?php

session_start();

// ensures no one can directly access this page. People who try to access this page without logging in will be re-directed to login page

if (isset($_SESSION['adminUser']))
{
	echo "<p>You are logged in as: ".$_SESSION['adminUser']."</p>";
}
	
else if (isset($_SESSION['employeeUser']))
{
	echo "<p>You are logged in as: ".$_SESSION['employeeUser']."</p>";
}
	
else if (isset($_SESSION['managerUser']))
{
	echo "<p>You are logged as: ".$_SESSION['managerUser']."</p>";
}

else
{
	header('Location: index.php');
}

echo "<h2>Addresses of Customers</h2>";

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$customerArray = array();
$customerQuery = "SELECT Email, FirstName, LastName, Address, City, State, ZipCode FROM Customers";
$customerQueryResult = $connecting->query($customerQuery);

for ($count = 0; $row = $customerQueryResult->fetch_assoc(); $count++)
{
	$customerArray[$count] = $row;
}

echo "<table = border=\"0\" width = 50% cellspacing=\"0\">
<thead>
<tr bgcolor = #cccc99>
<th align = \"left\">Email</th>
<th align = \"left\">Last Name</th>
<th align = \"left\">First Name</th>
<th align = \"left\">Address</th>
<th align = \"left\">City</th>
<th align = \"left\">State</th>
<th align = \"left\">Zip Code</th>
</tr>
</thead>";

foreach ($customerArray as $row)
{
	$customerEmail = $row['Email'];
	$customerLastName = $row['LastName'];
	$customerFirstName = $row['FirstName'];
	$customerAddress = $row['Address'];
	$customerCity = $row['City'];
	$customerState = $row['State'];
	$customerZipCode = $row['ZipCode'];
	
	echo "<tr>
	<td>$customerEmail</td>
	<td>$customerLastName</td>
	<td>$customerFirstName</td>
	<td>$customerAddress</td>
	<td>$customerCity</td>
	<td>$customerState</td>
	<td>$customerZipCode</td>
	</tr>";
}

echo "</table>";

//makes sure that the user returns to correct previous page. For example, someone logged in as an admin should return to the admin
//page not the manager page
if (isset($_SESSION['adminUser']))
{
	echo "<p><a href = admin.php>Return to previous page</a></p>";
}

if (isset($_SESSION['employeeUser']))
{
	echo "<p><a href = employee.php>Return to previous page</a></p>";
}

if (isset($_SESSION['managerUser']))
{
	echo "<p><a href = manager.php>Return to previous page</a></p>";
}

?>