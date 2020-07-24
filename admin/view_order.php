<?php

	session_start();
	include("../db/db_config.php");
	include('../db/authenticate.php');
	aut_admin();
	$admin_name = $_SESSION['administrator_name'];


?>


<!DOCTYPE html>
<html>
<head>
	<title>View All Orders Page</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/table.css">
	
</head>
<body>

	<header>
		<h1>
			View Order Page
		</h1>
		<nav>
			<a href="admin_home.php">Admin Home</a>
			<a href="logout.php">Click to Logout</a>
		</nav>

	</header>

	<a href="admin_home.php">Admin Home</a>

	<h3>View All Orders:</h3>


	<?php $select = mysqli_query($db, "SELECT * FROM orders") or die(mysqli_error($db)); ?>

	<div class="table">

		<table border="1" class="content-table">
			<?php
				 echo "<p>Current Admin: <strong>$admin_name</strong></p>";
			
			?>
			<thead>

		<tr>
			
			<th>Order Date</th>
			<th>Customer ID</th>
			<th>Product ID</th>
			<th>Merchant ID</th>
			<th>Quantity</th>

		</tr>
		</thead>
		<tbody>

			<tr>
				
				<?php while($result = mysqli_fetch_array($select)) { ?>

					<td><?php echo $result[1] ?></td>
					<td><?php echo $result[2] ?></td>
					<td><?php echo $result[3] ?></td>
					<td><?php echo $result[4] ?></td>
					<td><?php echo $result[5] ?></td>

				
			</tr>
		</tbody>
		<?php } ?>
	
	</table>

	<?php echo "<p>Number of Rows: <strong>".mysqli_num_rows($select)."</strong></p>"; ?>



</body>
</html>