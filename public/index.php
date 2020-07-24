<?php 

	session_start();
	include('../db/db_config.php');
	$status="";
	if(isset($_POST['p_key']) && $_POST['p_key'] != ""){

		$p_key = $_POST['p_key'];
		$result = mysqli_query($db, "SELECT * FROM products WHERE product_id = '$p_key' ")
					or die(mysqli_error($db));

		$row = mysqli_fetch_assoc($result);
		$name = $row['name'];
		$p_key = $row['product_id'];
		$price = $row['price'];
		$uploaded_image = $row['uploaded_image'];

		$cartArray = array($p_key =>array('name'=>$name,'p_key'=>$p_key,'price'=>$price,'quantity'=> 1,
			'uploaded_image' =>$uploaded_image));

		if(empty($_SESSION['shopping_cart'])) {
			$_SESSION['shopping_cart'] = $cartArray;

			$status = "<div class='box'>Product is added to your cart!</div>";

		}	else {
			$array_keys = array_keys($_SESSION["shopping_cart"]);
			if(in_array($p_key,$array_keys)){
			$status = "<div class='box' style='color:red'>Product is already added to your cart!</div>";	
			} else{
				$_SESSION['shopping_cart'] = array_merge($_SESSION["shopping_cart"], $cartArray);
				$status = "<div class='box'>Product is added to your cart!</div>";
			}

		}	

	}




?>

<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<?php 
		if(!empty($_SESSION['shopping_cart'])){
				$cart_count = count(array_keys($_SESSION['shopping_cart']));
	?>

		 <a href="cart.php">Cart <?php echo $cart_count; ?></a>
	<?php } ?>

	<?php 
		$result = mysqli_query($db,"SELECT * FROM products");
		while($row = mysqli_fetch_assoc($result)){
			echo "<div class='product_wrapper'>
					<form method='post' action=''>
						<input type='hidden' name='p_key' value=".$row['product_id']."/>
						<div class='image'><img src='".$row['uploaded_image']."'/></div>
						<div class='name'>".$row['name']."</div>
						<div class='price'>N".$row['price']."</div>
						<button type='submit' class='buy'>Buy Now</button>
					</form>
				  </div>";
		}
		mysqli_close($db);
	 ?>

	 <div style="clear:both;"></div>

	 <div class="message_box" style="margin:10px 0px;"></div>
	 <?php echo $status; ?>
	<!-- <h3>Products List</h3> -->
	<?php 
			// if(isset( $_POST['qua'])){
			// 	$_SESSION['qua'] = $_POST['qua'];
			// } 
	 ?>




</body>
</html>