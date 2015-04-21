<?php

session_start();

//check to see if user has hit submit button
if (isset($_POST['email']) && isset($_POST['pass']))
{
	
	$userName = $_POST['email'];
	$passCode = $_POST['pass'];
	//When a password is set and stored to database it is encrypted with sha1. Therefore, the password the user inputs
	//should be also converted via sha1 so it matches the password stored in the database.
	$passCodeEncrypt = sha1($passCode);
		
	if (empty($userName) || empty($passCode))
	{
		echo "You have not entered in a name and/or password.";
	}
	
	else
	{	
		@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
		
		// Look for an entry in the table where all the accounts for regular users are stored
		$userQuery = "SELECT * FROM Customers WHERE Email = '$userName' AND Password = '$passCodeEncrypt'";
		$userQueryResult = $connecting->query($userQuery);
		
		//The query should returns one and only one result
		if ($userQueryResult->num_rows == 1)
		{
			$_SESSION['user'] = $userName;
			header('Location: main.php');
		}
		
		// Look for an entry in the Users table for all the Admin user accounts
		$queryAdmin = "SELECT * FROM Users WHERE Email = '$userName' AND Password = '$passCodeEncrypt' AND Type = 'Admin'";
		$queryAdminResult = $connecting->query($queryAdmin);
		
		if($queryAdminResult->num_rows == 1)
		{
			$_SESSION['adminUser'] = $userName;
			header('Location: admin.php');
		}
		
		// Look for an entry in the Users table for all the Employee user accounts
		$queryEmployee = "SELECT * FROM Users WHERE Email = '$userName' AND Password = '$passCodeEncrypt' AND Type = 'Employee'";
		$queryEmployeeResult = $connecting->query($queryEmployee);
		
		if($queryEmployeeResult->num_rows == 1)
		{
			$_SESSION['employeeUser'] = $userName;
			header('Location: employee.php');
		}
		
		// Look for an entry in the Users table for all the Manager user accounts
		$queryManager = "SELECT * FROM Users WHERE Email = '$userName' AND Password = '$passCodeEncrypt' AND Type = 'Manager'";
		$queryManagerResult = $connecting->query($queryManager);
		
		if($queryManagerResult->num_rows == 1)
		{
			$_SESSION['managerUser'] = $userName;
			header('Location: manager.php');
		}
		
		//A query was entered but nothing was found for any of the user types
		if (($queryResult->num_rows == 0) && (!empty($userName) || (!empty($passCode))))	
		{
			echo "You have entered in an invalid name and/or password";
		}
		
		$connecting->close();
	}
		
}
		
?>

<html>
<head>
<title> Please Log In </title>
</head>
<body>

<form method="post" action="index.php">
<table>
<tr><td>E-mail:</td>
<td><input type="text" name="email"></td></tr>
<tr><td>Password:</td>
<td><input type="password" name="pass"></td></tr>
<tr><td colspan="2" align="center">
<input type ="submit" value="Log In"></td></tr>
</form>
</table>

<p>This is a website being developed for a project for a databases course at Montclair State University by Steven Lin. The purpose of the website is to simulate an
actual e-commerce website on the web</p>

<p>To login as an administrator, enter in slin@mmamart.com for e-mail and 'shield' for the password</p>
<p>To login as a manager, enter in tonytorres@mmamart.com.com for e-mail and 'purple' for the password.</p>
<p>To login as an employee, enter in dhardy@mmamart.com for e-mail and 'roughhouse' for the password.</p>
<p>To login as a customer, enter in joecustomer@yahoo.com for e-mail and 'nygiants' for the password. If
you wish to register a new customer account, please click <a href = customerRegister.php>here</a></p>

</body>
</html>