<?php

	session_start();
	
	include('../db/db_config.php');



?>

<!DOCTYPE html>
<html>
<head>
	<title>Merchant Login</title>
	<link rel="stylesheet" type="text/css" href="../css/login.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
</head>
<body>
	<header>
		<h1>XYZ</h1>
		<nav>
			
		</nav>
	</header>

	<?php

			if(array_key_exists('login', $_POST))
			{
				$error = array();

				if(empty($_POST['uname']))
				{
					$error['uname'] = "*";

				}	else {

					$uname = mysqli_real_escape_string($db, $_POST['uname']);
				}
				if(empty($_POST['pword']))
				{
					$error['pword'] = "*";

				}	else {

					$pword = md5(mysqli_real_escape_string($db, trim($_POST['pword'])));
				}
					if(empty($error))
					{
						$query = mysqli_query($db, "SELECT * FROM merchant
							WHERE username='".$uname."' AND secured_password='".$pword."'")


						or die(mysqli_error($db));

						if(mysqli_num_rows($query) == 1){
						$result = mysqli_fetch_array($query) or die(mysqli_error($db));

						$_SESSION['merchant_id'] = $result['merchant_id'];
						$_SESSION['name'] = $result['name'];
						$_SESSION['phone_number'] = $result['phone_number'];
						$_SESSION['email'] = $result['email'];
						$_SESSION['username'] = $result['username'];
						$_SESSION['address'] = $result['address'];
						$_SESSION['date_registered'] = $result['date_registered'];




						header("location:view_product.php");

						} else{
							$msg = "Incorrect username or password";
							header("location:login.php?msg=$msg");
						}
					}
			}

	?>

	<form action="" method="post">
		<p><span><?php if(isset($_GET['msg'])) echo $_GET['msg'] ?></span></p>
	<p><label>Username: <span><?php if(isset($error['uname'])) echo $error['uname'] ?></span></label> 
		<input type="text" name="uname" value="<?php if(isset($uname)) echo $uname ?>" 
			/></p>


	<p><label>Password: <span><?php if(isset($error['pword'])) echo $error['pword'] ?></span></label>
		<input type="password" name="pword"value="<?php if(isset($pword)) echo $pword ?>" 
		/></p>

	<p><input type="submit" name="login" value="Click to Login"></p>
	<p>Don't have an account? <a href="sign_up.php">Sign Up</a></p>

	</form>
	
	


</body>
</html>