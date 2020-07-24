<?php

	session_start();

	include('../db/db_config.php');

?>


<!DOCTYPE html>
<html>
<head>
	<title>Admin Login Page</title>
	<link rel="stylesheet" type="text/css" href="../css/login.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
</head>
<body>


	
	<?php

			if(array_key_exists('login', $_POST))
			{
				$error = array();
				
				if(empty($_POST['admin_name']))
				{
					$error['admin_name'] = "*";

				}	else {

					$admin_name = mysqli_real_escape_string($db, trim($_POST['admin_name']));
				}

				if(empty($_POST['pword'])) 
				{
					$error['pword'] = "*";

				}	else {

					$pword = mysqli_real_escape_string($db, trim($_POST['pword']));
				}

				if(empty($error))
				{
					$query = mysqli_query($db, "SELECT * FROM admin 
								WHERE admin_name='".$admin_name."' AND password='".$pword."'")

					or die(mysqli_error($db));

					if($rows = mysqli_num_rows($query) == 1) {
					$result=mysqli_fetch_array($query);
					$_SESSION['administrator_name'] = $result['admin_name'];

					header("location:admin_home.php");

					} else {

						$msg = "Invalid Admin Name and or Admin Password";
						header("location:admin_login.php?msg=$msg");

					}

				}
				
			}

			


	?>
	<header>
		<h1>XYZ</h1>
		<nav>
			
		</nav>
	</header>

	
	<form action="" method="post">
		
		<h3 class="login_header">Admin Login</h3>
		
		<p><label><span><?php if(isset($_GET['msg']))
			{
				echo $_GET['msg'];
			}
		 	?></span></label>
		</p>
		<p><label>Admin Name:
			<span><?php if(isset($error['admin_name'])) echo $error['admin_name'] ?></span>
			</label><input type="text" name="admin_name"value="<?php if(isset($admin_name)) echo $admin_name ?>" >
		</p>

		<p><label>Password: <span><?php if(isset($error['pword'])) echo $error['pword'] ?></span></label> <input type="password" name="pword"
			value="<?php if(isset($pword)) echo $pword  ?>" 
			></p>

		<p><input type="submit" name="login" value="Login"></p>

	</form>



</body>
</html>