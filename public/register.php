<?php
	
	session_start();
	include('../db/db_config.php');

	$query = mysqli_query($db, "SELECT * FROM customers");

	// $customer_id = $_SESSION['customer_id'];
	// $fname = $_SESSION['fname'];
	// $lname = $_SESSION['lname'];
	// $address = $_SESSION['address'];
	// $email = $_SESSION['email'];
	// $number = $_SESSION['number'];
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Registration</title>
</head>
<body>

		<h2>Customer Registration</h2>
		<p>Please fill the form fields below</p>

		<?php 
			if(isset($_POST['register']))
			{
				$error = array();

				if(empty($_POST['fname']))
				{
					$error['fname'] = "Enter your Firstname";
				} else {
					$firstname = mysqli_real_escape_string($db, trim($_POST['fname']));
				}

				if(empty($_POST['lname']))
				{
					$error['lname'] = "Enter your Lastname";
				} else {
					$lastname = mysqli_real_escape_string($db, trim($_POST['lname']));
				}

				if(empty($_POST['address']))
				{
					$error['address'] = "Enter your address";
				} else{
					$address = mysqli_real_escape_string($db, trim($_POST['address']));
				}

				if(empty($_POST['email']))
				{
					$error['email'] = "Enter your email";
				} else {
					$email = mysqli_real_escape_string($db, trim($_POST['email']));
				}
				$select = mysqli_query($db, "SELECT phone_number FROM customers") or die(mysqli_error($db));

				if(empty($_POST['number']))
				{
					$error['number'] = "Enter your Phone Number";
				} else {
					$number = mysqli_real_escape_string($db, trim($_POST['number']));
					$select = mysqli_query($db, "SELECT phone_number FROM customers") or die(mysqli_error($db));
					while($result = mysqli_fetch_assoc($select)){
					if(in_array("$number", $result)){
						$error['number'] = "Phone Number already exist";
					} 				
				}
				}
				

				if(empty($error))
				{
					$query = mysqli_query($db,"INSERT INTO customers 
												VALUES(NULL,
													   '".$firstname."',
													   '".$lastname."',
													   '".$address."',
													   '".$email."',
													   '".$number."'
													)") or die(mysqli_error($db));

					echo "<h2> Successfully Registered! You can now login!!</h2>";
				}
							
			}

		?>

		


		<form action="" method="post">

			<p>Firstname: <input type="text" name="fname" 
				value="<?php if(isset($_POST['fname'])) echo $_POST['fname']?>"/>
				<?php if(isset($error['fname'])) echo $error['fname'] ?>
			</p>
			<p>Lastname: <input type="text" name="lname" 
				value="<?php if(isset($_POST['lname'])) echo $_POST['lname']?>"/>
				<?php if(isset($error['lname'])) echo $error['lname'] ?>
			</p>
			<p>Address: <input type="text" name="address"
				value="<?php if(isset($_POST['address'])) echo $_POST['address']?>"/>
				<?php if(isset($error['address'])) echo $error['address'] ?>
			</p>
			<p>E-mail: <input type="text" name="email"
				value="<?php if(isset($_POST['email'])) echo $_POST['email']?>"/>
				<?php if(isset($error['email'])) echo $error['email'] ?>
			</p>
			<p>Phone Number: <input type="text" name="number" maxlength="11"
				value="<?php if(isset($_POST['number'])) echo $_POST['number']?>"/>
				<?php if(isset($error['number'])) echo $error['number'] ?>
			</p>

			<input type="submit" name="register" value="Register">
			<p>Have an account? <a href="order.php">Signin</a></p>
		</form>




</body>
</html>