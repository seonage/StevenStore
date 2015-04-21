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

// Stores the Product_ID of the item being modified so it can be used for a query on
// newItemInformationResult.php
$_SESSION['ID'] = $_GET['Product_ID'];

if ($productID = $_GET['Product_ID'])
{
	// Retrieving the Product_Category, Product_Name, and Price values for the item to be modified and then
	// displaying the values so users can see the values the items currently have before making changes
	@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
	$getItemInfo = "SELECT Product_Category, Product_Name, Price FROM Products WHERE Product_ID = '$productID'";
	$getItemInfoQuery = $connecting->query($getItemInfo);
	$itemInfo = $getItemInfoQuery->fetch_assoc();
	$itemCategory = $itemInfo['Product_Category'];
	$itemName = $itemInfo['Product_Name'];
	$itemPrice = $itemInfo['Price'];
	
	echo "<h3>The current values for the item that is to be modified are: </h3>";
	echo "Category: "."<b>$itemCategory</b></br>";
	echo "Name: "."<b>$itemName</b></br>";
	echo "Price: "."<b>$itemPrice</b></br>";
}

?>

<h2>Enter in the new values for the selected item below</h2>

<form action = "newItemInformationResult.php" method = "post">
<table border = "0">
	<tr>
		<td>Product Category: </td>
		<td><input type: "text" name = "productCategory" maxlength = "30" size = "30"></td>
	</tr>
	<tr>
		<td>Product Name: </td>
		<td><input type: "text" name = "productName" maxlength = "50" size = "50"></td>
	</tr>
	<tr>
		<td>Product Price: </td>
		<td><input type: "text" name = "productPrice" maxlength = "10" size = "10"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit"></td>
	</tr>

</table>
</form>

<?php

echo "<p><a href = modifyItem.php>Return to previous page</a></p>";

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