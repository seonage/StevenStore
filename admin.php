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


?>

<html>
<head>
  <title>Administration</title>
  <link type="text/css" rel="stylesheet" href="style.css"/>
</head>

<body>
<h2> Please Select The Task You Wish to Perform </h2>

<div><p><a href = "addItem.php">Add Item</a></p></div>
<div><p><a href = "addUser.php">Add User</a></p></div>
<div><p><a href = "deleteItem.php">Delete Item</a></p></div>
<div><p><a href = "deleteUser.php">Delete User</a></p></div>
<div><p><a href = "modifyItem.php">Modify Item</a></p></div>
<div><p><a href = "modifyUser.php">Modify User</a></p></div>
<div><p><a href = "viewCustomers.php">View Customer Addresses</a></p></div>
<div><p><a href = "viewItems.php">View Items</a></p></div>
<div><p><a href = "viewOrders.php">View Orders</a></p></div>
<div><p><a href = "viewUsers.php">View Users</a></p></div>
<p><a href = "logout.php">Log out</a></p>
  
</body>
</html>