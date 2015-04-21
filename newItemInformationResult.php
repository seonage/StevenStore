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

// $productID will be used later in the query $changeItem. It will be used
// to identify which item changes are being made to.
$productID = $_SESSION['ID'];

if (isset($_POST['productCategory'])&& isset($_POST['productName']) && isset($_POST['productPrice']))
{
	$productCategory = $_POST['productCategory'];
	$productName = $_POST['productName'];
	$productPrice = $_POST['productPrice'];
		
	// If any of the input boxes are empty, show this message
	if (empty($productCategory) || empty($productName) || empty($productPrice))
	{
		echo "<p>Please fill in all the boxes</p>";
	}
		
	else
	{
		// Makes sure the admin has entered in a number for price as opposed to a string
  		if (is_numeric($productPrice) == false)
  		{
  			echo "<p>Please enter a decimal number for the price</p>";
  		}
  			
  		else
  		{
  			@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
  				
  			if (mysqli_connect_errno()) 
			{
     				echo "<p>The database could not be connected to</p>";
  			}
  				
  			else
  			{
  				$changeItem = "UPDATE Products 
  				SET Product_Category = '$productCategory', Product_Name = '$productName', Price = '$productPrice'
  				WHERE Product_ID = '$productID'";
  					
  				$changeItemQuery = $connecting->query($changeItem);
  					
  				if ($changeItemQuery == false)
  				{
  					echo "<p>There was a problem with updating the item</p>";
  				}
  					
  				else
  				{
  					echo "<p>The item information was updated successfully</p>";
  				}
  			}
  		}
	}
}

//clear the session global super array
$_SESSION['ID'] = array();

echo "<p><a href = modifyItem.php>Modify another item</a></p>";

//makes sure that the user returns to correct previous page. For example, someone logged in as an admin should return to the admin
//page not the manager page
if (isset($_SESSION['adminUser']))
{
	echo "<p><a href = admin.php>Return to admin page</a></p>";
}

if (isset($_SESSION['managerUser']))
{
	echo "<p><a href = manager.php>Return to manager page</a></p>";
}

?>