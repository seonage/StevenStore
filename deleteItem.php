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


echo "<h2>Please select the category of the item you wish to delete</h2>";

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$categoryQuery = "SELECT DISTINCT Product_Category FROM Products";
$categoryResult = @$connecting->query($categoryQuery);
	
if (!categoryResult)
{
	echo "<p>Could not query database</p>";
}
	
$numCategories = @ $categoryResult->num_rows;
	
if ($numCategories == 0)
{
	echo "<p>No catagories were found</p>";
}
	
$categoryArray = array();
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

echo "<h2>Please select the category of the item(s) you wish to view</h2>";

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$categoryQuery = "SELECT DISTINCT Product_Category FROM Products";
$categoryResult = @$connecting->query($categoryQuery);
	
if (!categoryResult)
{
	echo "<p>Could not query database</p>";
}
	
$numCategories = @ $categoryResult->num_rows;
	
if ($numCategories == 0)
{
	echo "<p>No categories were found</p>";
}
	
$categoryArray = array();
	
for ($count = 0; $row = $categoryResult->fetch_assoc(); $count++)
{
	$categoryArray[$count] = $row;
}
	
		
foreach ($categoryArray as $row)
{
	$url = "http://codd.cs.montclair.edu/~lins/deleteItem.php?Product_Category=".($row['Product_Category']);
	$title = $row['Product_Category'];
	echo "<a href=$url>$title</a></br>";
}

if ($categoryID = $_GET['Product_Category'])
{
	echo "<p>Select the item you want to delete from the ".$_GET['Product_Category']." category:</p>";
	
	$itemArray = array();
	$itemsQuery = "SELECT * FROM Products WHERE Product_Category = '$categoryID'";
	$itemsQueryResult = @$connecting->query($itemsQuery);
	
	for ($count = 0; $row = $itemsQueryResult->fetch_assoc(); $count++)
	{
		$itemArray[$count] = $row;
	}
	
	foreach ($itemArray as $row)
	{
		$url = "http://codd.cs.montclair.edu/~lins/deleteItem.php?Product_ID=".($row['Product_ID']);
		$itemName = $row['Product_Name'];
		echo "<a href=$url>$itemName</a></br>";
	}
}

if ($ProductID = $_GET['Product_ID'])
{
	@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
	$deleteQuery = "DELETE FROM Products WHERE Product_ID = '$ProductID'";
	$deleteItem = $connecting->query($deleteQuery);
	
	if($deleteItem == true)
	{
		echo "<p>Item was deleted from database</p>";
	}
	else
	{
		echo "<p>Error: item was not deleted from database</p>";
		echo $ProductID;
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
