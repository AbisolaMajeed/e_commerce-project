<?php
		session_start();
		include('../db/db_config.php');
		
?>
<!DOCTYPE html>
<html>
<head>
	<title>Merchant | Sign Up</title>
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/signup.css">
</head>
<body>
	<header>
		<h1>Merchant Sign Up</h1>
		<nav>
			
		</nav>
	</header>

			<?php

				if(isset($_POST['submit']))
				{
					$error = array();

					if(empty($_POST['name']))
					{
						$error['name'] = "Please enter your business name";
					} else {
						$name = mysqli_real_escape_string($db, trim($_POST['name']));
					}

					if(empty($_POST['address']))
					{
						$error['address'] = "Please enter your address";
					} else {
						$address = mysqli_real_escape_string($db, trim($_POST['address']));
					}

					if(empty($_POST['number']))
					{
						$error['number'] = "Please enter your Phone Number";
					} else {
						$number = mysqli_real_escape_string($db, trim($_POST['number']));
					}

					if(empty($_POST['email']))
					{
						$error['email'] = "Please enter your email";
					} else {
						$email = mysqli_real_escape_string($db, trim($_POST['email']));
					}

					if(empty($_POST['username']))
					{
						$error['username'] = "Please enter your username";
					} else {
						$username = mysqli_real_escape_string($db, trim($_POST['username']));
					}

					if(empty($_POST['password']))
					{
						$error['password'] = "Please enter your password";
				
					} else {
						$password = mysqli_real_escape_string($db, trim($_POST['password']));
					}

					if(empty($error))
					{
						$query = mysqli_query($db, "INSERT INTO merchant
													VALUES(NULL,
													'".$name."',
													'".md5($password)."',
													'".$number."',
													'".$email."',
													'".$username."',
													'".$password."',
													'".$address."',
													NOW()
													
													)") or die(mysqli_error($db));

						$mer = mysqli_query($db, "SELECT * FROM merchant
							WHERE username ='".$username."' AND secured_password='".md5($password)."'")

						or die(mysqli_error($db));

						if(mysqli_num_rows($mer) == 1){
							$result = mysqli_fetch_array($mer) or die(mysqli_error($db));

							$_SESSION['merchant_id'] = $result['merchant_id'];
							$_SESSION['name'] = $result['name'];
							$_SESSION['phone_number'] = $result['phone_number'];
							$_SESSION['email'] = $result['email'];
							$_SESSION['username'] = $result['username'];
							$_SESSION['address'] = $result['address'];
							$_SESSION['date_registered'] = $result['date_registered'];




						header("location:view_product.php");
						}
					
					} 



				}

					


			?>

		<form action="" method="post">

			<p><label>Business Name: </label><input type="text" name="name" 
				value="<?php if(isset($_POST['name'])) echo $_POST['name'] ?>"/>
				<span><?php if(isset($error['name'])) echo $error['name'] ?> </span>
			</p>

			<p><label>Address: </label><input type="text" name="address" 
				value="<?php if(isset($_POST['address'])) echo $_POST['address']?>"/>
				<span><?php if(isset($error['address'])) echo $error['address'] ?></p></span>

			<p><label>Phone Number: </label><input type="text" name="number" 
				value="<?php if(isset($_POST['number'])) echo $_POST['number']?>"/>
				<span><?php if(isset($error['number'])) echo $error['number'] ?></p></span>

			<p><label>Email: </label><input type="text" name="email" 
				value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>"/>
				<span><?php if(isset($error['email'])) echo $error['email'] ?></p></span>

			<p><label>Username: </label><input type="text" name="username" 
				value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>"/>
				<span><?php if(isset($error['username'])) echo $error['password'] ?></p></span>

			<p><label>Password: </label><input type="password" name="password" 
				value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>"/>
				<span><?php if(isset($error['password'])) echo $error['password'] ?></p></span>

			<p><input type="submit" name="submit" value="Sign Up"></p>
			<div class="already">
					<p>Already have an account? </p>
					<a href="login.php">Login</a>
			</div>
		</form>

		
</body>
</html>