<?php

session_start();

// ensures no one can directly access this page. People who try to access this page without logging in will be re-directed to login page
if (!isset($_SESSION['employeeUser']))
{
	header('Location: index.php');
}
else
{
	echo '<p>You are logged in as: '.$_SESSION['employeeUser'].'</p>';
}


?>

<html>
<head>
  <title>Employee Tasks</title>
  <link type="text/css" rel="stylesheet" href="style.css"/>
</head>

<body>
<h2> Please Select The Task You Wish to Perform </h2>

<p><a href = "viewCustomers.php">View Customer Addresses</a></p>
<p><a href = "viewItems.php">View Items</a></p>
<p><a href = "viewOrders.php">View Orders</a></p>
<p><a href = "viewUsers.php">View Users</a></p>
<p><a href = "logout.php">Log out</a></p>

</body>
</html>