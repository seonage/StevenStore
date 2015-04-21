?php

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
	
for ($count = 0; $row = $categoryResult->fetch_assoc(); $count++)
{
	$categoryArray[$count] = $row;
}
	
		
foreach ($categoryArray as $row)
{
	$url = "http://codd.cs.montclair.edu/~lins/categoryItems.php?Product_Category=".($row['Product_Category']);
	$title = $row['Product_Category'];
	Echo "<a href=$url>$title</a></br>";
}


?>

<a href = searchItems.php>Search For An Item</a></br>
<a href = cart.php>View Shopping Cart</a></br>
<a href = logout.php>Log out</a>

<link type="text/css" rel="stylesheet" href="style.css"/>