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

// Tells the page what item category from the database is being handled
$categoryID = $_GET['Product_Category'];
	
@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
// query to select all items in the category that is indicated by $categoryID
$itemQuery = "SELECT * FROM Products WHERE Product_Category = '$categoryID'";
// stores query result
$itemResult = @$connecting->query($itemQuery);
	
// If the query fails, return this message
if (!itemResult)
{
	echo "<p>Could not query database</p>";
}
	
// See how many items are in the category
$numItems = @ $itemResult->num_rows;

// If no items are in category, return this message
	if ($numItems == 0)
	{
		echo "<p>No items were found</p>";
	}
	
$itemArray = array();
	
// Fills associate array with all the items in the category
for ($count = 0; $row = $itemResult->fetch_assoc(); $count++)
{
	$itemArray[$count] = $row;
}
	
// Creates a list of items in the category and creates a link to a page for each of the items
echo "<table>";

foreach ($itemArray as $row)
{
	$url = "http://codd.cs.montclair.edu/~lins/showItem.php?Product_ID=".($row['Product_ID']);
	$itemName = $row['Product_Name'];
	echo "<tr><td>";
	
	if (@file_exists("Images/".$row['Product_ID'].".jpg"))
	{
		$image = $row['Product_ID'].".jpg";
		echo "<img src = \"Images/".$image."\" width = \"100\" height = \"150\" style = \"border: 1px solid black\">";
	}
	
	echo "<td><a href=$url>$itemName</a></td>";
	echo "</td></tr>";
}

echo "</table>";

?>

<a href = cart.php>View Shopping Cart</a></br>
<a href = main.php>Return to front page</a>