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

if (isset($_POST['search']))
{
	$search = $_POST['search'];
	
	if (empty($search))
	{
		echo "<p>You have not entered in a search term. Please enter in something to search for.</p>";
	}
	
	else
	{
		@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
		
		$searchItem = "SELECT * FROM Products WHERE Product_Name LIKE '%$search%'";
		$searchItemQuery = $connecting->query($searchItem);
		$searchArray = array();
		
		if ($searchItemQuery->num_rows == 0)
		{
			echo "<p>No items found</p>";
		}
		
		else
		{
			for ($count = 0; $row = $searchItemQuery->fetch_assoc(); $count++)
			{
				$searchArray[$count] = $row;
			}
			
			foreach ($searchArray as $row)
			{
				$itemName = $row['Product_Name'];
				$url = "http://codd.cs.montclair.edu/~lins/showItem.php?Product_ID=".($row['Product_ID']);
				echo "<a href = $url>$itemName</a></br>";
			}
		}
	}
}

?>

<p>Enter what item you wish to search for:</p>

<form action = "searchItems.php" method = "post">
<input type = "text" name = "search" maxlength = "30" size = "20">
<input type = "submit" value = "Search">
</form>

<p><a href = "main.php">Return to previous page</a></p>