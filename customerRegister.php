<?php

if (isset($_POST['Email']) || isset($_POST['FirstName'])|| isset($_POST['LastName']) || isset($_POST['Address']) 
|| isset($_POST['City']) || isset($_POST['State']) || isset($_POST['ZipCode']) || isset($_POST['Password']) 
|| isset($_POST['PasswordConfirm']))
{
	$email = $_POST['Email'];
	$firstName = $_POST['FirstName'];
	$lastName = $_POST['LastName'];
	$address = $_POST['Address'];
	$city = $_POST['City'];
	$state = $_POST['State'];
	$zipCode = $_POST['ZipCode'];
	$password = $_POST['Password'];
	$passwordConfirm = $_POST['PasswordConfirm'];
	$passwordEncrypt = sha1($password);
	
	if (empty($email) || empty($firstName)|| empty($lastName)|| empty($address) || empty($city) || empty($state) || empty($zipCode) 
	|| empty($password) || empty($passwordConfirm))
	{
		echo "<p>Please fill out all the fields</p>";
	}
	
	else
	{
		if ($password !== $passwordConfirm)
		{
			echo "<p>The passwords entered do not match. Please enter matching password</p>";
		}
		
		else
		{
			@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
			
			//Since every user's email must be unique we must check to see that new user does not have an already used email
			$emailCheck = "SELECT Email FROM Customers";
			$emailCheckQuery = $connecting->query($emailCheck);
			$emailCheckQueryArray = array();
			$emailArray = array();
			
			//Fetch all of the customer accounts currently in database and stores in $emailCheckQueryArray array
			for ($count = 0; $row = $emailCheckQuery->fetch_assoc(); $count++)
			{
				$emailCheckQueryArray[$count] = $row;
			}
			
			//Extract the Email value from $emailCheckQueryArray and store it in $emailArray
  			$count = 0;
  			foreach ($emailCheckQueryArray as $row)
  			{
  				$emailArray[$count] = $row['Email'];
  				$count++;
  			}
			
			if (in_array($email, $emailArray))
			{
				echo "<p>The email address you entered is already in use. Please choose a different email address</p>";
			}
			
			else
			{
			
				$newCustomer = "INSERT INTO Customers
				VALUES('$email', '$firstName', '$lastName', '$passwordEncrypt', '$address', '$city', '$state', '$zipCode')";	
				$newCustomerQuery = $connecting->query($newCustomer);
			
				if ($newCustomerQuery == false)
				{
					echo "<p>Error: customer not added to database</p>";
				}
			
				else
				{
					echo "<p>Registration is complete. You may log on with the registered email address and password</p>";
				}
			}
		}
	}
	
}

?>

<html>
<head>
  <title>New Cutomer Registration</title>
</head>

<body>

<h2>New Customer</h2>

<p>Please fill in the following information: </p>


 <form action="customerRegister.php" method="post">
    <table border="0">
      <tr>
        <td>Email: </td>
         <td><input type="text" name="Email" maxlength="30" size="30"></td>
      </tr>
      <tr>
        <td>First Name: </td>
         <td><input type="text" name="FirstName" maxlength="20" size="20"></td>
      </tr>
      <tr>
        <td>Last Name: </td>
         <td><input type="text" name="LastName" maxlength="20" size="20"></td>
      </tr>
      <tr>
        <td>Address: </td>
         <td><input type="text" name="Address" maxlength="20" size="20"></td>
      </tr>
      <tr>
        <td>City: </td>
         <td><input type="text" name="City" maxlength="20" size="20"></td>
      </tr>
      <tr>
		<td>State: </td>
		<td><select name = 'State'>
		<option value = "AL">Alabama</option>
		<option value = "AK">Alaska</option>
		<option value = "AZ">Arizona</option>
		<option value = "AR">Arkansas</option>
		<option value = "CA">California</option>
		<option value = "CT">Connecticut</option>
		<option value = "DE">Delaware</option>
		<option value = "DC">District of Columbia</option>
		<option value = "FL">Florida</option>
		<option value = "GA">Georgia</option>
		<option value = "HI">Hawaii</option>
		<option value = "ID">Idaho</option>
		<option value = "IL">Illinois</option>
		<option value = "IN">Indiana</option>
		<option value = "IA">Iowa</option>
		<option value = "KS">Kansas</option>
		<option value = "LS">Louisiana</option>
		<option value = "ME">Maine</option>
		<option value = "MD">Maryland</option>
		<option value = "MA">Massachusetts</option>
		<option value = "MN">Minnesota</option>
		<option value = "MS">Mississippi</option>
		<option value = "MO">Missouri</option>
		<option value = "MT">Montana</option>
		<option value = "NE">Nebraska</option>
		<option value = "NV">Nevada</option>
		<option value = "NH">New Hampshire</option>
		<option value = "NJ">New Jersey</option>
		<option value = "NM">New Mexico</option>
		<option value = "NY">New York</option>
		<option value = "NC">North Carolina</option>
		<option value = "ND">North Dakota</option>
		<option value = "OH">Ohio</option>
		<option value = "OK">Oklahoma</option>
		<option value = "OR">Oregon</option>
		<option value = "PA">Pennsylvania</option>
		<option value = "RI">Rhode Island</option>
		<option value = "SC">South Carolina</option>
		<option value = "SD">South Dakota</option>
		<option value = "TN">Tennessee</option>
		<option value = "TX">Texas</option>
		<option value = "UT">Utah</option>
		<option value = "VT">Vermont</option>
		<option value = "VA">Virginia</option>
		<option value = "WA">Washington</option>
		<option value = "WV">West Virginia</option>
		<option value = "WI">Wisconsin</option>
		<option value = "WY">Wyoming</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>Zip Code: </td>
		<td><input type: "text" name = "ZipCode" maxlength = "5" size = "5"></td>
	</tr>
      <tr>
        <td>Password: </td>
        <td> <input type="Password" name="Password" maxlength="20" size="20"></td>
      </tr>
        <tr>
        <td>Confirm the password: </td>
        <td> <input type="Password" name="PasswordConfirm" maxlength="20" size="20"></td>
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