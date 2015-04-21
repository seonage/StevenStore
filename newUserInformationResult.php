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

// $userMail will be used later in the query $changeUser. It will be used
// to identify which user changes are being made to.
$userEmail = $_SESSION['Email'];

if (isset($_POST['userEmail'])&& isset($_POST['userFirstName']) && isset($_POST['userLastName']) && ($_POST['userType']) && isset($_POST['userPassword']) && isset($_POST['userPasswordConfirm']))
{
	$userEmail = $_POST['userEmail'];
	$userFirstName = $_POST['userFirstName'];
	$userLastName = $_POST['userLastName'];
	$userType = $_POST['userType'];
	$userPassword = $_POST['userPassword'];
	$userPasswordConfirm = $_POST['userPasswordConfirm'];
	//enncrypting the password so that when it is added to database it is not stored in plain text
	$passwordEncrypt = sha1($userPassword);
	
	// If any of the input boxes are empty, show this message
	if (empty($userEmail) || empty($userFirstName) || empty($userLastName) || empty($userPassword) || empty($userPasswordConfirm))
	{
		echo "<p>Please fill in all the boxes</p>";
	}
	
	else
	{
		if ($userPassword !== $userPasswordConfirm)
		{
			echo "<p>The passwords entered do not match. Please try again</p>";
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
  				$modifyUser = "UPDATE Users
  				SET Email = '$userEmail', FirstName = '$userFirstName', LastName = '$userLastName', Type = '$userType', Password = '$passwordEncrypt'
  				WHERE Email = '$userEmail'";
  				
  				$modifyUserQuery = $connecting->query($modifyUser);
  				
  				if ($modifyUserQuery == false)
  				{
  					echo "<p>There was a problem with updating the user</p>";
  				}
  				
  				else
  				{
  					echo "<p>The user has been updated</p>";
  				}
  			}
  		}
	}
}

//clear the session global super array
$_SESSION['Email'] = array();
?>

<p><a href = "modifyUser.php">Modify another user</a></p>
<p><a href = "admin.php">Return to administration page</a></p>