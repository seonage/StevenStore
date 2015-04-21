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

if (isset($_POST['firstName']) || isset($_POST['lastName']) || isset($_POST['address']) || isset($_POST['city']) || isset($_POST['state']) || isset($_POST['zipcode']))
{
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zipCode = $_POST['zipCode'];
		$email = $_SESSION['user'];
		
		if (empty($firstName) || empty($lastName) || empty($address) || empty($_POST['city']) || empty($state) || empty($zipCode))
		{
			echo "Please fill in all the fields";
		}
		
		else
		{
			@ $connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
		
			$changeCustomerInfo = "UPDATE Customers
				       SET FirstName = '$firstName', LastName = '$lastName', Address = '$address', City = '$city', State = '$state', ZipCode = '$zipCode'
				       WHERE Email = '$email'";
				       
			$changeCustomerInfoQuery = $connecting->query($changeCustomerInfo);
			
			if($changeCustomerInfoQuery == false)
			{
				echo "There was a problem with the updating the address";
			}
			
			else
			{
				echo "Your address has been updated successfully";
			}
		}
		
}

?>

<h2>Please enter your address information in the form below</h2>

<form action = "changeAddress.php" method = "post">
<table border = "0">
	<tr>
		<td>First Name: </td>
		<td><input type: "text" name = "firstName" maxlength = "20" size = "20"></td>
	</tr>
	<tr>
		<td>Last Name: </td>
		<td><input type: "text" name = "lastName" maxlength = "20" size = "30"></td>
	</tr>
	<tr>
		<td>Address: </td>
		<td><input type: "text" name = "address" maxlength = "20" size = "30"></td>
	</tr>
	<tr>
		<td>City: </td>
		<td><input type: "text" name = "city" maxlength = "25" size = "25"></td>
	</tr>
	<tr>
		<td>State: </td>
		<td><select name = 'state'>
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
		<td><input type: "text" name = "zipCode" maxlength = "5" size = "5"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit Address Change"></td>
	</tr>

</table>
</form>

<a href = cart.php>Return to Shopping Cart</a></br>