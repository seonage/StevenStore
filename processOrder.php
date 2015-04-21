<?php

session_start();

// ensures no one can directly access this page. People who try to access this page without logging in will be re-directed to login page
if (!isset($_SESSION['user']))
{
	header('Location: index.php');
}

else
{
	echo '<p>You are logged in as: '.$_SESSION['user'].'</p>';
}

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');

$queryNumRows = "SELECT * FROM Orders";
$queryNumRowsResult = $connecting->query($queryNumRows);

/*
If "Orders" table is currently empty, no need to check to see if an orderID has already been used since
there isn't any other orderID currently existing. If the table is currently empty, then running a forloop with "finderOrderIDArray"
will lead to a notice since if the table is empty, "inderOrderIDArray" will also be empty and a forloop
acting upon the empty array will lead to a notice.
*/

//If the 'Orders' table is currently empty, generate a random number that serve as the OrderID for the first order made
if($queryNumRowsResult->num_rows == 0)
{
	$orderID = rand();
}

else
{
	do
	{
		$orderID = rand();

		@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
		$queryFindOrderID = "SELECT OrderID FROM Orders";
		$queryFindOrderIDResult = $connecting->query($queryFindOrderID);
		$findOrderIDArray = array();

	for($i = 0; $row = $queryFindOrderIDResult->fetch_assoc(); $i++)
	{
		$finderOrderIDArray[$i] = $row;
	}

	$uniqueArray = array();
	$counter = 0;

	//This loop geneates a notice if the table "Orders" is currently empty. This is why the if statement up on line 29 is being used -
	// so if the table is empty then this loop will not be run.
	foreach ($finderOrderIDArray as $row)
	{
		$uniqueArray[$counter] = $row['OrderId'];
		$counter++;
	}

	$uniqueArray = array_unique($uniqueArray);
	}
	while(in_array($orderID, $uniqueArray ));
}

/*
Every time an order is checked out, each item that is in the shopping cart will be added to it's own row on the 'Orders' table.
Each row must have a unique key value otherwise there will be problems with the table. $numRow will serve as the
key value since all the other values in the table cannot be unique (eg. OrderID can't be unique since customers often have more than
one kind of product in their shopping cart which results in each product having their own row and all the products being ordered together
will have the same OrderID. OrderTime can't be unique since customers often order multiple items at the same time and all
the items being ordered together will have the same time stamp. ProductOrdered can't be unique since the same products get bought
over and over again and each product will appear in the table many times).

$numRow gets it's value from the number of rows currently present in the 'Orders' table. Each time a new item is added to the table, $numRow
is incremented by 1. This ensures that every new order that is added to the 'Orders' table will always be added at the end of the table and will always
have an unique 'Row' value.
*/
@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$queryNumRows = "SELECT * FROM Orders";
$queryNumRowsResult = $connecting->query($queryNumRows);
$rowNum = ($queryNumRowsResult->num_rows)+1;



foreach($_SESSION['cart'] as $item => $quantity)
{
	@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
	$orderTime = (Date("F d, Y, H:i:s"));
	$email = $_SESSION['user'];
	$insertItem = "INSERT INTO Orders VALUES ('$rowNum','$orderID','$email','$orderTime','$item','$quantity')";
	$insertItemResult = $connecting->query($insertItem);
	$rowNum++;
}


if ($insertItemResult == true)
{
	echo "<p>Order processed</p>";
}

else
{
	echo "<p>Order not processed</p>";
}

?>

<a href = main.php>Return to front page</a>