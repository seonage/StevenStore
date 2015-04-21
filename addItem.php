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

echo "<h2>Please enter in the information for the item below</h2>";
echo "<p>Please note a new item category will be created if a category that doesn't currently exist in the database is entered</p>";
	
if (isset($_POST['newID']) && isset($_POST['newName'])&& isset($_POST['newCategory']) && isset($_POST['newPrice']))
{
	$newID = $_POST['newID'];
	$newName = $_POST['newName'];
	$newCategory = $_POST['newCategory'];
	$newPrice = $_POST['newPrice'];
		
	// If any of the input boxes are empty, show this message
	if (empty($newID) || (empty($newName)) || empty($newCategory)|| empty($newPrice))
	{
     		echo "<p>Please fill in all the boxes</p>";
  	}
  		
  	else
  	{
  		// Makes sure the admin has entered in a number for price as opposed to a string
  		if (is_numeric($newPrice) == false)
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
  				// Since every productID must be unique, this else branch makes sure that the user doesn't enter in an productID that is already being used
  				$query = "SELECT Product_ID FROM Products";
				$queryResult = $connecting->query($query);
				$queryResultArray = array();
				$productIDArray = array();
				
				// Fetches all the products that are currently in the database and stores each product in a row of the $queryResultArray array
				for ($count = 0; $row = $queryResult->fetch_assoc(); $count++)
				{
					$queryResultArray[$count] = $row;
				}
				
				// Extract the product_ID value from each item in $queryResultArray and store it in $productIDArray
				$count = 0;
				
				foreach ($queryResultArray as $row)
				{
					$productIDArray[$count] = $row['Product_ID'];
					$count++;
				}
				
				//Checks to see if the productID value entered in by the user is already present in $productIDArray which would mean it is already in use
				if (in_array($newID , $productIDArray))
				{
					echo "The ProductID you entered is already in use. Please choose another ProductID";	
				}
				
				else
				{
  					$insertQuery = "INSERT into Products VALUES ('$newID', '$newCategory', '$newName', '$newPrice')";
					$insertQueryResult = $connecting->query($insertQuery);
			
					if ($insertQueryResult == true) 
					{
      						echo  "<p>The item has been successfully added to the database</p>";
  					} 
  			
  					if ($insertQueryResult ==  false)
					{
						echo "<p>Error: Item not added to database</p>";
  					}
  				}
  			}
  		
  		}
  			
  	}
}

// conditional branch runs if user uploads photo
if ($_FILES['picture']['name'])
{
	if (!$_FILES['picture']['error'])
	{	// Only JPEG/JPG images should be used
		if ($_FILES['picture']['type'] !== "image/jpeg")
		{
			echo "<p>Only images in jpg format are accepted</p>";
		}
		// Picture file should not be more then 1 kilobyte
		else if($_FILES['picture']['size'] > (102000))
		{
			echo "<p>All images shoud be less than 1 kilobyte in size/<p>";
		}
		
		else
		{
			$fileName = $_FILES['picture']['name'];
			move_uploaded_file($_FILES['picture']['tmp_name'], '/home/lins/www/Images/'.$fileName);
			echo "<p>Picture has been successfully uploaded</p>";
		}
	}
	
	else
	{
		echo "<p>The upload attempt resulted in the following error: ".$_FILES['picture']['error']."</p>";
	}

}

?>

<html>
<head>
  <title>Item Insertion</title>
</head>

<body>

<form action="addItem.php" method="post">
<table>
	<tr>
        	<td>Choose A Unique ProductID For the Item: </td>
        	<td><input type="text" name="newID" maxlength="30" size = "30"></td>
	</tr>
	<tr>
        	<td>Name of the Product: </td>
        	<td> <input type="text" name="newName" maxlength="50" size = "50"></td>
	</tr>
	<tr>
      		<td>Category of the Product:</td>
      		<td><input type="text" name="newCategory" maxlength="30" size = "30"></td>
	</tr>
	<tr>
		<td>Price of the Product (Enter in decimal format with no dollar sign):</td>
		<td><input type="text" name="newPrice" maxlength="10" size = "10"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit"></td>
	</tr>
</table>
</form>

<h2>Upload Item Picture Here</h2>

<p>For the image to show up in the same page as the item, the image file should have the exact same name as the Product ID of the item</p>

<form action="addItem.php" method="post" enctype="multipart/form-data">
Upload Item Picture: <input type="file" name="picture" size="25"/>
<input type="submit" name="submit" value="Upload Picture"/>
</form>
  
</body>
</html>

<?php

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