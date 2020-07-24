<?php 
	session_start();
	include("../db/db_config.php");
	include('../db/authenticate.php');
	aut_public();
		 //$q = $_SESSION['qua'];
	$customer_id = $_SESSION['customer_id'];

	$status="";
	if(isset($_POST['action']) && $_POST['action'] == "remove"){
		if(!empty($_SESSION['shopping_cart'])){
			foreach($_SESSION['shopping_cart'] as $key => $value){
				if($_POST['p_key'] == $key){
					unset($_SESSION["shopping_cart"][$key]);
					$status = "<div class='box' style='color:red;'>Product is removed from your cart!</div>";
				}
				if(empty($_SESSION["shopping_cart"])) unset($_SESSION["shopping_cart"]);
			}
		}
	}

	if(isset($_POST['action']) && $_POST['action'] == "change"){
		foreach ($_SESSION["shopping_cart"] as &$value) {
			if($value['p_key'] === $_POST['p_key']){
				$value['quantity'] = $_POST["quantity"];
				break; //Stop the loop afterwe've found the product
			}
		}
	}
	// var_dump($_SESSION["shopping_cart"]);
	// echo $_SESSION['shopping_cart'][1]['p_key'];
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Cart</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
 </head>
 <body>
 	<div class="cart">
 		<?php 
 			if(isset($_SESSION["shopping_cart"])){
 				$total_price = 0;
 		 ?>
 		 <table class="table">
 		 	<tbody>
 		 		<tr>
 		 			<td></td>
 		 			<td>ITEM NAME</td>
 		 			<td>QUANTITY</td>
 		 			<td>UNIT PRICE</td>
 		 			<td>ITEMS TOTAL</td>
 		 		</tr>
 		 		<?php 
 		 		foreach ($_SESSION["shopping_cart"] as $product) {
 		 			$p_id = $product["p_key"];
 		 			$qua = $product["quantity"];
 		 			$merchant = mysqli_query($db,"SELECT merchant_id FROM products WHERE product_id = '$p_id' ")
 		 						or die(mysqli_error($db));
 		 			$merchant_result = mysqli_fetch_array($merchant) or die(mysqli_error($db));
 		 			$mer_id = $merchant_result[0];

 		 			if(isset($_POST['checkout'])){
 		 				$insert = mysqli_query($db,"INSERT INTO orders VALUES(NULL,NOW(),
 		 									'".$customer_id."','".$p_id."','".$mer_id."','".$qua."')")
 		 						or die(mysqli_error($db));
 		 				if($insert){
 		 					header("location:checkoutsuccess.php");
 		 				} else{
	 		 				header("location:checkoutfailed.php");
	 		 			}
 		 			} 
 		 		 ?>
 		 		 <tr>
 		 		 	<td>
 		 		 		<img src='<?php echo $product["uploaded_image"]?>' width="50" height="40" />
 		 		 	</td>
 		 		 	<td><?php echo $product["name"]; ?><br>
 		 		 		<form method="post" action="">
 		 		 			<input type="hidden" name="p_key" value="<?php echo $product["p_key"]; ?>" />
 		 		 			<input type="hidden" name="action" value="remove" />
 		 		 			<button type='submit' class='remove'>Remove Item</button>
 		 		 		</form>
 		 		 	</td>
 		 		 	<td>
 		 		 	  <form method="post" action="">
 		 		 		<input type="hidden" name="p_key" value="<?php echo $product["p_key"]; ?>" />
 		 		 		<input type="hidden" name="action" value="change" />
 		 		 		<select name='quantity' class="quantity" onChange="this.form.submit()">
 		 		 		  <option <?php if($product["quantity"] == 1) echo "selected"; ?> value="1">1</option>
 		 		 		  <option <?php if($product["quantity"] == 2) echo "selected"; ?> value="2">2</option>
 		 		 		  <option <?php if($product["quantity"] == 3) echo "selected"; ?> value="3">3</option>
 		 		 		  <option <?php if($product["quantity"] == 4) echo "selected"; ?> value="4">4</option>
 		 		 		  <option <?php if($product["quantity"] == 5) echo "selected"; ?> value="5">5</option>
 		 		 		</select>
 		 		 	  </form>
 		 		 	</td>
 		 		 	<td><?php echo "N".$product['price']; ?></td>
 		 		 	<td><?php echo "N".$product['price']*$product["quantity"]; ?></td>
 		 		 </tr>

 		 		 <?php 
	 		 		 $total_price += ($product['price']*$product["quantity"]);
	 		 		 }
 		 		  ?>
 		 		 <tr>
 		 		 	<td colspan="5" align="right">
 		 		 		<strong>TOTAL: <?php echo "N".$total_price; ?></strong>	
 		 		 	</td>
 		 		 </tr>
 		 	</tbody>
 		 </table>
 		 <?php 
 		 	}else{
 		 		//echo "<h3>Your cart is empty!</h3>";
 		 		header("location:index.php");
 		 	}
 		  ?>
 	</div>
 	<div style="clear: both; "></div>
 	<div class="message_box" style="margin: 10px 0px;">
 		<?php echo $status ?>
 	</div>
 	<form method="post" action="">
 		<input type="submit" name="checkout" value="Check Out">
 	</form>
 		
 	 </body>
 </html>