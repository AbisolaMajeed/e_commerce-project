<?php 
	session_start();
	include("../db/db_config.php");
	include('../db/authenticate.php');
	aut_merchant();

	$product_id = $_GET['id'];


	$select = mysqli_query($db, "SELECT * FROM products WHERE product_id = $product_id ") or die(mysqli_error($db));

 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Details</title>
 	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/viewproduct.css">
 </head>
 <body>
 	<header>
 		<h1>XYZ</h1>
 		<nav>
	 		<a href="view_product.php">Home</a>
	 		<a href="view_order.php">View Order</a>
	 		<a href="logout.php">Logout</a>
	 	</nav>
 	</header>
 	
 		<div>
 			<?php  $result = mysqli_fetch_array($select); ?>

	 		<h2><?php echo $result['name'] ?></h2>
	 		<img src="<?php echo $result['uploaded_image']  ?>">
	 		<p><?php  echo $result['description'] ?></p>
	 		<p><?php echo $result['price']; ?></p>
	 		<a href="update.php?id=<?php echo $result['product_id']  ?>">Update</a>
 		</div>
 		
 		

 				
 				
 </body>
 </html>