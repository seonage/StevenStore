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

if (isset($_POST['newEmail']) && isset($_POST['newFirstName']) && isset($_POST['newLastName']) && isset($_POST['newPass']) && isset($_POST['passwordConfirm']))
{
	$newEmail = $_POST['newEmail'];
	$UserType = $_POST['userType'];
	$newFirstName = $_POST['newFirstName'];
	$newLastName = $_POST['newLastName'];
	$newPass = $_POST['newPass'];
	//enncrypting the password so that when it is added to database it is not stored in plain text
	$newPassEncrypt = sha1($newPass);
	$passwordConfirm = $_POST['passwordConfirm'];
		
	if (empty($newEmail) || empty($newFirstName) || empty($newLastName) || empty($newPass) || empty($passwordConfirm))
	{
     		echo "<p>Please fill in all the boxes</p>";
  	}
  		
  	else
  	{
  		if ($newPass !== $passwordConfirm)
  		{
  			echo "<p>The passwords entered do not match. Please try again</p>";
  		}
  		
  		else
  		{
    			
    			@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
    			
    			if (mysqli_connect_error()) 
			{
     				echo "<p>The database could not be connected to</p>";
  			}
  		
  			else
  			{
  				//Since every user's email must be unique we must check to see that new user does not have an already used email
  				$emailQuery = "SELECT Email FROM Users";
  				$emailQueryResult = $connecting->query($emailQuery);
  				$emailQueryResultArray = array();
  				$emailArray = array();
  		
  				//Fetch all of the user accounts currently in database and stores in $emailQueryResultArray array
  				for($count = 0; $row = $emailQueryResult->fetch_assoc(); $count++)
  				{
  					$emailQueryResultArray[$count] = $row;
  				}
  		
  				//Extract the Email value from $emailQueryResultArray and store it in $emailArray
  				$count = 0;
  		
  				foreach($emailQueryResultArray as $row)
  				{
  					$emailArray[$count] = $row['Email'];
  					$count++;
  				}
  			
  				//Check to see if the Email entered by the user is in $emailArray which would mean that it is already in use
  				if(in_array($newEmail, $emailArray))
  				{
  					echo "<p>The email address you entered is already in use. Please choose a different email address</p>";
  				}
  			
  				else
  				{
  					$insertQuery = "INSERT INTO Users VALUES ('$newEmail', '$UserType', '$newFirstName', '$newLastName', '$newPassEncrypt')";
					$insertQueryResult = $connecting->query($insertQuery);
			
					if (insertQueryResult == true) 
					{
      						echo  "<p>The new user has been successfully added to the database</p>";
  					} 
  			
  					if (insertQueryResult ==  false)
					{
						echo "<p>Error: User not added to database</p>";
  					}
  				}
  			}
  		
  		}
  	}
}

?>

<html>
<head>
  <title>User Insertion</title>
</head>

<body>

<h2>Add A New User</h2>

<p>Please fill in the following information for the new user account</p>

<ul>
<li>Administrators are able to add new users, delete users, modify user information including passwords, add items, delete items, modify item information, and view 
users, items, and processed orders.</li>
<li>Employees are able to view users, view processed orders and view items in stock. They cannot modify information.</li>
<li>Managers are able to add items, delete items, modify item information, view users and view processed orders.</li>
</ul>

  <form action="addUser.php" method="post">
    <table border="0">
      <tr>
        <td>Email: </td>
         <td><input type="text" name="newEmail" maxlength="30" size="30"></td>
      </tr>
      <tr>
      <td>User Type:</td>
      <td><select name = 'userType'>
      <option value = 'Admin'>Administrator</option>
      <option value = 'Employee'>Employee</option>
      <option value = 'Manager'>Manager</option>
      </select>
      </td>
      </tr>
      <tr>
        <td>First Name: </td>
         <td><input type="text" name="newFirstName" maxlength="20" size="20"></td>
      </tr>
      <tr>
        <td>Last Name: </td>
         <td><input type="text" name="newLastName" maxlength="20" size="20"></td>
      </tr>
      <tr>
        <td>Password To Be Added: </td>
        <td> <input type="password" name="newPass" maxlength="20" size="20"></td>
      </tr>
        <tr>
        <td>Confirm the password: </td>
        <td> <input type="password" name="passwordConfirm" maxlength="20" size="20"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Submit"></td>
      </tr>
    </table>
  </form>
  
  <p><a href = "admin.php">Return to previous page</a></p>
  <p><a href = "logout.php">Log out</a></p>
</body>
</html>