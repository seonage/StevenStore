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
	
// Tells the page what item from the database is being handled
$productID = $_GET[Product_ID];

@ $productConnect = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
// Query to select the item indicated in $productID by looking in Product Table and searching Product_ID
$productQuery = "SELECT * FROM Products WHERE Product_ID = '$productID'";
// stores query result
$productQueryResult = $productConnect->query($productQuery);
  	
if (!$productQueryResult)
	{
		// If the query fails, return this message
     		echo "<p>Could not query database</p>";
	}
	
	// Should only return one row if item is found since Product_ID is unique for each item
	$productFound = @ $productQueryResult->num_rows;
 
	if ($productFound == 0)
	{
		// The query worked but did not find the item with the Product_ID indicated
		echo "<p>The item was not found</p>";
	}
	
	// Creates an associate array out of the query result and stores in $queryStoreResult
	$productQueryResult = $productQueryResult->fetch_assoc();
	
	if (is_array($productQueryResult))
	{	
		// looks for corresponding image in Images folder
		if (@file_exists("Images/".$productQueryResult['Product_ID'].".jpg"))  
		{
			echo "<td><img src=\"Images/".$productQueryResult['Product_ID'].".jpg\"style=\"border: 1px solid black\"/></td>";
		}
	}
	
	echo "<h2>$productQueryResult[Product_Name]</h2>";
	echo "<p><strong>$$productQueryResult[Price]</strong></p>";
	echo "<a href = cart.php?itemAdded=$productID>Add Item To Cart</a></br>";
	
?>

<a href = cart.php>View Shopping Cart</a></br>
<a href = "categoryItems.php">Continue Shopping</a>