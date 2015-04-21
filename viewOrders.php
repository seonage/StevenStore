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

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');

$orders = "SELECT OrderID, CustomerEmail, OrderTime, ProductOrdered, Quantity FROM Orders";
$ordersQuery = $connecting->query($orders);

if ($ordersQuery == false)
{
	echo "<p>There was an error with the query</p>";
}

else
{
	$ordersArray = array();
	
	for ($count = 0; $row = $ordersQuery->fetch_assoc(); $count++)
	{
		$ordersArray[$count] = $row;
	}
	
	echo "<table = border=\"0\" width = 50% cellspacing=\"0\">
	<thead>
	<tr bgcolor = #cccc99>
	<th align = \"left\">OrderID</th>
	<th align = \"left\">Customer Email</th>
	<th align = \"left\">Time of Order</th>
	<th align = \"left\">Product</th>
	<th align = \"left\">Quantity</th>
	</tr>
	</thead>";
	
	foreach ($ordersArray as $row)
	{
		$orderID = $row['OrderID'];
		$customerEmail = $row['CustomerEmail'];
		$orderTime = $row['OrderTime'];
		$productOrdered = $row['ProductOrdered'];
		$quantity = $row['Quantity'];
		
		echo "<tr>
		<td>$orderID </td>
		<td>$customerEmail</td>
		<td>$orderTime</td>
		<td>$productOrdered</td>
		<td>$quantity</td>
		</tr>";
	}
	
	echo "</table>";
}

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