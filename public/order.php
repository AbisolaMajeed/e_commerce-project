<?php 
	session_start();
	include("../db/db_config.php");
		 //$q = $_SESSION['qua'];


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
 		 		 ?>
 		 		 <tr>
 		 		 	<td>
 		 		 		<img src='<?php echo $product["uploaded_image"]?>' width="50" height="40" />
 		 		 	</td>
 		 		 	<td><?php echo $product["name"]; ?><br>
 		 		 		<form method="post" action="">
 		 		 			<input type="hidden" name="p_key" value="<?php echo $product["p_key"]; ?>" />
 		 		 			<?php 
 		 		 				$_SESSION['p_key'] = $product["p_key"]; 
 		 		 				$p_id = $_SESSION['p_key'];


 		 		 			?>
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
 		 		 	<?php $_SESSION['quantity'] = $product["quantity"]; ?>

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





<?php 
	if(!isset($_SESSION)){
		session_start();
	}
	include("../db/db_config.php");
			$error = [];


 		
 			
 			if(empty($_POST['email'])){
 				$error['email'] = "*";
 			} else{
 				$email = mysqli_real_escape_string($db,trim($_POST['email']));
 			}
 			if(empty($_POST['number'])){
 				$error['number'] = "*";
 			} else{
 				$number = mysqli_real_escape_string($db,trim($_POST['number']));
 			}
 			if(!empty($error)){
 				$msg = 'order';
 			}

 			if(empty($error)){
 				$customers = mysqli_query($db,"SELECT * FROM customers WHERE email = '".$email."' AND phone_number = '".$number."' ") or die(mysqli_error($db)); 
 				$result = mysqli_fetch_array($customers) or die(mysqli_error($db));
 				$customer_id = $result[0];
 				$email = $result['email'];
 				$number = $result['phone_number'];
 				$_SESSION['customer_id'] = $customer_id;
 				$_SESSION['email'] = $email;
 				$_SESSION['number'] = $number;


 				if(mysqli_num_rows($customers) == 1){
 					header("location:checkout.php");
 					//$insert = mysqli_query($db,"INSERT INTO orders VALUES(NULL,
 											//NOW(),'".$customer_id."') ");
 				}
 			}	


 ?>


 		<form method="post" action="">
 			<input type="email" name="email" placeholder="Email" 
 				value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>"/>
 				<?php if(isset($error['email'])) echo $error['email'] ?>
 			<input type="number" name="number" placeholder="Phonenumber" maxlength="11"
 				value="<?php if(isset($_POST['number'])) echo $_POST['number'] ?>"/>
 				<?php if(isset($error['number'])) echo $error['number'] ?>
 			<input type="submit" name="signin" value="Sign In">
 		</form>
 		<p>Not a Registered user? Click <a href="register.php">here</a> to register</p>

 </body>
 </html>