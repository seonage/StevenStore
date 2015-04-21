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

@$item = $_GET['itemAdded'];

if (isset($item))
	{
		if ($item == 'emptyCart')
		{
			$_SESSION['cart'] = array();
		}
		
		else if (isset($_SESSION['cart'][$item]))
		{
			$_SESSION['cart'][$item]++;
		}
		
		else
		{
			$_SESSION['cart'][$item] = 1;
		}
		
	}
	
if (isset($_POST['save']))
{
	foreach($_SESSION['cart'] as $item => $quantity)
	{
		if($_POST[$item] == 0)
		{
			unset($_SESSION['cart'][$item]);
		}
		
		else
		{
			$_SESSION['cart'][$item] = $_POST[$item];
		}
	}
}

	
if ($_SESSION['cart'])
	{	
		$priceTotal = 0;
		
		echo "<html>
		      <body>
		      <form method = \"post\" action = \"cart.php\">
		      <table border=\"0\" width = 50% cellspacing=\"0\">
		      <thead>
		      <tr bgcolor = #cccc99>
		      <th align = \"left\">Item</th>
		      <th align = \"left\">Quantity</th>
		      <th align = \"left\">Price</th>
		      </tr>
		      </thead>";
	
		foreach ($_SESSION['cart'] as $item => $quantity)
			{
				$connection = new mysqli('localhost', 'lins_user', 'shi86D7!', 'lins_test');
				
				// Find the price for all products in $_SESSION['cart'] array and saves each price value to a $price variable which is then printed out in a table row
				$queryPrice = "SELECT Price FROM Products WHERE Product_ID = '$item'";
				$queryPriceResult = $connection->query($queryPrice);
				$priceFetch = $queryPriceResult->fetch_assoc();
				$price = $priceFetch['Price'];
				$priceTotal = $priceTotal + ($price * $quantity);
				
				//Same process as above but only with the product name instead of the price
				$queryProductName = "SELECT Product_Name FROM Products WHERE Product_ID = '$item'"; 
				$queryProductNameResult = $connection->query($queryProductName);
				$productNameFetch = $queryProductNameResult->fetch_assoc();
				$productName = $productNameFetch['Product_Name'];
			
				echo "<tr><td>$productName</td>"."
				<td><input type = \"text\" name = \"$item\" value = \"$quantity\" size = \"2\"></td>"."
				<td>$price</td></tr>";
			}
			
		
		
		echo "<tfoot>
		      <tr>
		      <th align = \"left\" colspan = \"2\" style = \"border-top-style: solid; border-bottom-width: 1px\">Total Price:</th>
		      <th align = \"left\" style = \"border-top-style: solid; border-bottom-width: 1px\"> $priceTotal</th>
		      </tr>
		      <tr>
		      <th align = \"right\" colspan = \"3\"><input type = \"submit\" name = \"save\" value = \"Save Changes\"></th>
		      </tr>
		      </tfoot>
		      </table>
		      </form>";
		//Check out link should only appear if there are items in the cart
		echo "<p><a href = checkOut.php>Check Out</p>";
			   
	}
	
else
	{
		echo "<p>The cart is empty</p>";
	}

?>

<p><a href = cart.php?itemAdded=emptyCart>Empty the Cart</a></p>
<a href = main.php>Continue Shopping</a></br>
</body>
<html>
