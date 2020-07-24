<?php 
	session_start();
	include("../db/db_config.php");
	include('../db/authenticate.php');
	aut_merchant();
	
	$product_id = $_GET['id'];

	$merchant_id = $_SESSION['merchant_id'];
	$merchant_name = $_SESSION['name'];
	$phone_number = $_SESSION['phone_number'];
	$email = $_SESSION['email'];
	$username = $_SESSION['username'];
	$address = $_SESSION['address'];
	$reg = $_SESSION['date_registered']; 

	$select = mysqli_query($db,"SELECT * FROM products WHERE product_id = $product_id ") or die(mysqli_error($db));
	$result = mysqli_fetch_array($select);


	if(isset($_POST['update'])){
		$error = [];

			if(empty($_POST['name'])){
				$error['name'] = "*";
			} else {
				$name = mysqli_real_escape_string($db, trim($_POST['name']));
				$update = mysqli_query($db, "UPDATE products SET name = '".$name."' WHERE product_id = $product_id  ")
										or die(mysqli_error($db));
			}

			if(empty($_POST['desc'])){
				$error['desc'] = "*";
			} else {
				$desc = mysqli_real_escape_string($db, trim($_POST['desc']));
				$update = mysqli_query($db, "UPDATE products SET description = '".$desc."' WHERE product_id = $product_id  ")
									or die(mysqli_error($db));
			}

			if(empty($_POST['price'])){
				$error['price'] = "*";
			} else {
				$price = mysqli_real_escape_string($db, trim($_POST['price']));
				$update = mysqli_query($db, "UPDATE products SET price = '".$price."' WHERE product_id = $product_id  ")
										or die(mysqli_error($db));
			}

			if(empty($_POST['cat'])){
				$error['cat'] = "*";
			} else {
				$cat = mysqli_real_escape_string($db, trim($_POST['cat']));
				$update = mysqli_query($db, "UPDATE products SET category_id = '".$cat."' WHERE product_id = $product_id  ")
										or die(mysqli_error($db));
			}


			//PRODUCT IMAGE
			$max_size = 4000000;
			$extension = array("image/jpg", "image/jpeg","image/png");

			if(!empty($_FILES['image']['name'])){
				
				if($_FILES['image']['size'] > $max_size) {
					$error['image'] = "File too Large, Image should be within 4mb";
				} elseif(!in_array($_FILES['image']['type'], $extension)){
					$error['image'] = "File type not supported";
				} else{
					$filename = $_FILES['image']['name'];
					$destination = '../images/'.$filename; 
					$res = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
					$update = mysqli_query($db, "UPDATE products SET uploaded_image = '".$destination."' WHERE product_id = $product_id  ")
										or die(mysqli_error($db));
				}
			}

			$msg = "Your product have been updated successfully!!!";
		}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Product Update</title>
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
 	<section class="upload">
 	<form action="" method="post" enctype="multipart/form-data">
 			<?php if(isset($msg)){ ?>
 				<h2><?php echo $msg; ?></h2>
 			<?php } ?>
 			
 			<p><label>Product Name </label><span><?php if(isset($error['name'])) echo $error['name'] ?></span>
 				<input type="text" name="name" 
 				value="<?php echo $result['name'] ?>"/>
 			</p>
 			<p><label>Description</label><span> <?php if(isset($error['desc'])) echo $error['desc'] ?></span>
 				<input type="text" name="desc" 
 				value="<?php echo $result['description'] ?>" /> 
 			</p>
 			<p><label>Price </label><span><?php if(isset($error['price'])) echo $error['price'] ?></span>
 				<input type="number" name="price" 
 				value="<?php echo $result['price'] ?>" />
 			</p>
 			<p><label>Categories</label><span><?php if(isset($error['cat'])) echo $error['cat']; ?></span> <select name="cat"/>

 							<?php 
 								$category_id = $result['category_id'];
			 					$cat = mysqli_query($db,"SELECT * FROM categories WHERE category_id = $category_id") or die(mysqli_error($db));
			 					$cat_result = mysqli_fetch_array($cat);
			 				?>

			 				<option value="<?php echo $cat_result['category_id'] ?>"><?php echo $cat_result['category_name'] ?></option>
			 				<?php 
			 					$cat = mysqli_query($db,"SELECT * FROM categories") or die(mysqli_error($db));
			 					while ($row = mysqli_fetch_array($cat)){ 
			 				?>
			 				<option value="<?php echo $row['category_id'] ?>" >
			 					<?php echo $row['category_name'] ?>
			 				</option>
			 			<?php } ?>
 						</select>
 			</p>
 			
 			<img src="<?php echo $result['uploaded_image'] ?>" class=""/>
 			
 			
  			<p><label>Change Product Image</label>
  				<input type="file" name="image">
  				<?php if(isset($error['image'])) echo "<span>*".$error['image']."</span>" ?>
  			</p>
 			<input type="submit" name="update" value="Update">
 		</form>
 	</section>
 </body>
 </html>