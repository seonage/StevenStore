<?php

session_start();

// ensures no one can directly access this page
if (!isset($_SESSION['adminUser']))
{
	header('Location: index.php');
}

else
{
	echo '<p>You are logged in as: '.$_SESSION['adminUser'].'</p>';
}

// Stores the Product_ID of the item being modified so it can be used for a query on
// newItemInformationResult.php
$_SESSION['Email'] = $_GET['email'];

if ($userEmail = $_GET['email'])
{
	// Retrieving the Email, Type, FirstName, and LastName values for the user to be modified and then
	// displaying the values so users can see the values the user to be modified currently has before making changes
	@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
	$getUserInfo = "SELECT Email, Type, FirstName, LastName FROM Users WHERE Email = '$userEmail'";
	$getUserInfoQuery = $connecting->query($getUserInfo);
	$userInfo = $getUserInfoQuery->fetch_assoc();
	$userEmail = $userInfo['Email'];
	$userType = $userInfo['Type'];
	$userFirstName = $userInfo['FirstName'];
	$userLastName = $userInfo['LastName'];
	
	echo "<h3>The current values for the user that is to be modified are: </h3>";
	echo "Email: "."<b>$userEmail</b></br>";
	echo "Type: "."<b>$userType</b></br>";
	echo "First Name: "."<b>$userFirstName</b></br>";
	echo "Last Name: "."<b>$userLastName</b></br>";
}

?>

<h2>Enter in the new values for the selected user below</h2>

<form action = "newUserInformationResult.php" method = "post">
<table border = "0">
	<tr>
		<td>Email: </td>
		<td><input type: "text" name = "userEmail" maxlength = "30" size = "30"></td>
	</tr>
	<tr>
		<td>Type: </td>
		<td><select name = 'userType'>
      		<option value = 'Admin'>Administrator</option>
      		<option value = 'Employee'>Employee</option>
      		<option value = 'Manager'>Manager</option>
      		</select>
      		</td>
	</tr>
	<tr>
		<td>First Name: </td>
		<td><input type= "text" name = "userFirstName" maxlength = "20" size = "20"></td>
	</tr>
	<tr>
		<td>Last Name: </td>
		<td><input type= "text" name = "userLastName" maxlength = "20" size = "20"></td>
	</tr>
	<tr>
		<td>Password: </td>
		<td><input type= "password" name = "userPassword" maxlength = "12" size = "12"></td>
	</tr>
	<tr>
		<td>Confirm password: </td>
		<td><input type= "password" name = "userPasswordConfirm" maxlength = "12" size = "12"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit"></td>
	</tr>

</table>
</form>

<p><a href = modifyUser.php>Return to previous page</a></p>
<p><a href = "admin.php">Return to administration page</a></p>