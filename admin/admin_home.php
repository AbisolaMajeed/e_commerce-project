<?php

	session_start();

	include('../db/db_config.php');
	include('../db/authenticate.php');
	aut_admin();
	$admin_name = $_SESSION['administrator_name'];

?>






<!DOCTYPE html>
<html>
<head>
	<title>Admin Home</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
</head>
<body>
	<header>
		<h1>Admin Home Page</h1>
		<nav>
			<a href="view_merchant.php">View Merchant</a>
			<a href="view_order.php">View Orders</a>
			<a href="view_reg_cus.php">View Registered Customers</a>
			<a href="logout.php">Logout</a>
		</nav>
	</header>
	

	<?php
		
		echo "<p>Admin Name: <strong>$admin_name</strong></p>";
	?>

</body>
</html>