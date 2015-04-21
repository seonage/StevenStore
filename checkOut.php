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

echo "<h2>The following address is the address we have for you on file:</h2>";

$customer = $_SESSION['user'];

@$connecting = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
$queryCustomer = "SELECT * FROM Customers WHERE Email = '$customer'";
$queryCustomerResult = $connecting->query($queryCustomer);
$customerAddress = $queryCustomerResult->fetch_assoc();

echo "<b>First Name: </b>".$customerAddress['FirstName']."</br>";
echo "<b>Last Name: </b>".$customerAddress['LastName']."</br>";
echo "<b>Address: </b>".$customerAddress['Address']."</br>";
echo "<b>City: </b>".$customerAddress['City']."</br>";
echo "<b>State: </b>".$customerAddress['State']."</br>";
echo "<b>Zip Code: </b>".$customerAddress['ZipCode']."</br>";

?>

<p>If you wish to be make changes to your address, please <a href = changeAddress.php>click here</a></p>
<p>To finalize the order, please <a href = processOrder.php>click here</a></p>
<p><a href = main.php>Return to front page</a></p>