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

echo "<h2>Please select which category of items you wish to view</h2>";

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$categoryQuery = "SELECT DISTINCT Product_Category FROM Products";
$categoryResult = @$connecting->query($categoryQuery);
	
if (categoryResult == false)
{
	echo "<p>Could not query database</p>";
}
	
$numCategories = @ $categoryResult->num_rows;
	
if ($numCategories == 0)
{
	echo "<p>No catagories were found</p>";
}
	
$categoryArray = array();
	
for ($count = 0; $row = $categoryResult->fetch_assoc(); $count++)
{
	$categoryArray[$count] = $row;
}
	
		
foreach ($categoryArray as $row)
{
	$url = "http://codd.cs.montclair.edu/~lins/viewItems.php?Product_Category=".($row['Product_Category']);
	$title = $row['Product_Category'];
	Echo "<a href=$url>$title</a></br>";
}

if ($categoryID = $_GET['Product_Category'])
{
	$itemArray = array();
	$itemsQuery = "SELECT * FROM Products WHERE Product_Category = '$categoryID'";
	$itemsQueryResult = @$connecting->query($itemsQuery);
	
	for ($count = 0; $row = $itemsQueryResult->fetch_assoc(); $count++)
	{
		$itemArray[$count] = $row;
	}
	
	echo "<table = border=\"0\" width = 50% cellspacing=\"0\">
	<thead>
	<tr bgcolor = #cccc99>
	<th align = \"left\">ProductID</th>
	<th align = \"left\">Product Name</th>
	<th align = \"left\">Product Category</th>
	<th align = \"left\">Price</th>
	</tr>
	</thead>";
	
	foreach ($itemArray as $row)
	{
		$itemID = $row['Product_ID'];
		$itemName = $row['Product_Name'];
		$itemCategory = $row['Product_Category'];
		$itemPrice = $row['Price'];
		
		echo "<tr>
		<td>$itemID</td>
		<td>$itemName</td>
		<td>$itemCategory</td>
		<td>$itemPrice</td>
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