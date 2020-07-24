<?php 
	session_start();

	include("../db/db_config.php");
	include('../db/authenticate.php');
	aut_merchant();

	$merchant_id = $_SESSION['merchant_id'];
	$merchant_name = $_SESSION['name'];
	$phone_number = $_SESSION['phone_number'];
	$email = $_SESSION['email'];
	$username = $_SESSION['username'];
	$address = $_SESSION['address'];
	$reg = $_SESSION['date_registered']; 

	$select = mysqli_query($db,"SELECT * FROM products WHERE merchant_id = '$merchant_id' ");//$merchant_id

	if(isset($_POST['upload'])){
		$error = [];

		if(empty($_POST['name'])){
			$error['name'] = "*";
		} else {
			$name = mysqli_real_escape_string($db, trim($_POST['name']));
		}

		if(empty($_POST['desc'])){
			$error['desc'] = "*";
		} else {
			$desc = mysqli_real_escape_string($db, trim($_POST['desc']));
		}

		if(empty($_POST['price'])){
			$error['price'] = "*";
		} else {
			$price = mysqli_real_escape_string($db, trim($_POST['price']));
		}

		if(empty($_POST['cat'])){
			$error['cat'] = "*";
			// var_dump($error['cat'] );
		} else {
			$cat = mysqli_real_escape_string($db, trim($_POST['cat']));

		}


		//PRODUCT IMAGE
		$max_size = 4000000;
		$extension = array("image/jpg", "image/jpeg","image/png");

		if(empty($_FILES['image']['name'])){
			$error['image'] = "This field should not be empty";
		} elseif($_FILES['image']['size'] > $max_size) {
			$error['image'] = "File too Large, Image should be within 4mb";
		} elseif(!in_array($_FILES['image']['type'], $extension)){
			$error['image'] = "File type not supported";
		} elseif(!empty($_FILES['image']['name'])) {
			$filename = $_FILES['image']['name'];
			$destination = '../images/'.$filename; 
			$res = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

			if($res){
				$img_res =$destination;
			}
		}

		if(empty($error)){

			$query = mysqli_query($db, "INSERT INTO products
										VALUES(NULL,
											  '".$name."',
											  '".$desc."',
											  '".$price."',
											  NOW(),
											  '".$cat."',
											  '$merchant_id',
											  '".$destination."'

										)") or die(mysqli_error($db));

			$success_msg = "Product Successfully Uploaded!!!";
			header("location:view_product.php?msg=$success_msg");
		}
	}

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
	 		<a href="view_order.php">View Order</a>
	 		<a href="logout.php">Logout</a>
	 	</nav>
 	</header>
 	
 	<section class="upload">
 		<h3>Upload new products here</h3>
 		<form action="" method="post" enctype="multipart/form-data">
 			<?php if(isset($_GET['msg'])){
 				echo "<h2>".$_GET['msg']."</h2>";
 			}

 			?>
 			<p><label>Product Name </label><span><?php if(isset($error['name'])) echo $error['name'] ?></span>
 				<input type="text" name="name" 
 				value="<?php if(isset($_POST['name'])) echo $_POST['name'] ?>"/>
 			</p>
 			<p><label>Description </label><span><?php if(isset($error['desc'])) echo $error['desc'] ?></span>
 				<input type="text" name="desc" 
 				value="<?php if(isset($_POST['desc'])) echo $_POST['desc'] ?>" /> 
 			</p>
 			<p><label>Price</label><span> <?php if(isset($error['price'])) echo $error['price'] ?></span>
 				<input type="number" name="price" 
 				value="<?php if(isset($_POST['price'])) echo $_POST['price'] ?>" />
 			</p>
 			<p><label>Categories</label><span><?php if(isset($error['cat'])) echo $error['cat']; ?></span>
 							 <select name="cat"/>
			 				<option value="">Select Category</option>
			 				<?php 
			 					$cat = mysqli_query($db,"SELECT * FROM categories") or die(mysqli_error($db));
			 					while ($row = mysqli_fetch_array($cat)){ 
			 				?>
			 				<option value="<?php echo $row['category_id'] ?>" ><?php echo $row['category_name'] ?></option>
			 			<?php } ?>
 						</select>
 			</p>
 			
 			<?php if(isset($img_res)){ ?>
 				<img src="<?php echo $img_res ?>" class="img"/>
 			<?php } ?>		
 		
  			<p><label>Upload Product Image </label><input type="file" name="image">
  				<?php if(isset($error['image'])) echo "<span>*".$error['image']."</span>" ?></p>
 			<input type="submit" name="upload">
 		</form>
 		

 	</section>

 	<!-- FETCHING UPLOADED PRODUCTS FROM DATABASE-->
 	<h2>Your product uploads</h2>
 	<?php 
 		
 		while( $result = mysqli_fetch_array($select)){
 	 ?>
 
	 <a href="details.php?id=<?php echo $result['product_id']?>">
	 	<figure>
	 		<img src="<?php echo $result['uploaded_image'] ?>" class="img"/>
	 		<figcaption><?php echo $result['description'] ?></figcaption>
	 		<p>N <span><?php echo $result['price'] ?></span></p>
	 		<a href="details.php?id=<?php echo $result['product_id']?>">Edit</a>
	 	</figure>
	 </a>
 	<?php } ?>
 </body>
 </html>