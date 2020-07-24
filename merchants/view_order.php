<?php 
	session_start();
	include("../db/db_config.php");
	include('../db/authenticate.php');
	aut_merchant();

	$merchant_id = $_SESSION['merchant_id'];

	$select = mysqli_query($db,"SELECT * FROM orders WHERE merchant_id = '$merchant_id' ") 
				or die(mysqli_error($db));


 ?>

  <!DOCTYPE html>
 <html>
 <head>
 	<title>My Products</title>
 	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/viewproduct.css">
 </head>
 <body>
 	<header>
 		<h1>XYZ</h1>
 		<nav>
	 		<a href="view_product.php">Home</a>
	 		<a href="logout.php">Logout</a>
	 	</nav>
 	</header>
 			<h2>Ordered products</h2>
 			<?php while($result = mysqli_fetch_array($select)){
 				$p_id = $result['product_id'];
 				$c_id = $result['customer_id'];
 				$customer = mysqli_query($db,"SELECT * FROM customers WHERE customer_id = '$c_id' ") or die(mysqli_error($db));
 				$cus = mysqli_fetch_array($customer);
 				$product = mysqli_query($db,"SELECT * FROM products WHERE product_id = '$p_id' ") or die(mysqli_error($db));
 				$pro = mysqli_fetch_array($product);
 			 ?>
 				
		 	
		 	<figure>
		 		<img src="<?php echo $pro[7] ?>" class="img" />
		 		<figcaption>Description:  <?php echo $pro['description']?></figcaption>
		 		<p>Price: <span>N<?php echo $pro['price']?></span></p>
		 		<p>Quantity: <?php echo $result['quantity'] ?></p>
		 		<h3>Customer Details!!!</h3>
		 		<p>Name: <span><?php echo $cus['firstname']." ".$cus['lastname']; ?>  </span></p>
		 		<p>Phone Number: <span> <?php echo $cus['phone_number'] ?></span></p>
		 		<p>Delivery Address: <span> <?php echo $cus['address'] ?> </span></p>
		 	</figure>

		 <?php } ?>






 </body>
 </html>