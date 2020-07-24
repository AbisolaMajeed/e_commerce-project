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
	<title>View Merchant</title>
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/table.css">
</head>
<body>
	

	<header>
		<h1>
			View Merchant Page
		</h1>
		<nav>
			<a href="admin_home.php">Admin Home</a>
			<a href="logout.php">Click to Logout</a>
		</nav>

	</header>
	
	

	<?php  $select = mysqli_query($db, "SELECT * FROM merchant")  or die(mysqli_error($db)) ?>
	
	<div class="table">
	

		<table border="1" class="content-table">
			<?php
				echo "<p>Current Admin: <strong>$admin_name</strong></p>";
			
			?>
			<thead>
				<tr>
					<th>S/N</th>
					<th>Name</th>
					<th>Username</th>
					<th>Phone Number</th>
					<th>Email</th>
					
					
					<th>Address</th>
					<th>Date Registered</th>

				</tr>
			</thead>
			<tbody>
			<tr>
				
				<?php while($result = mysqli_fetch_array($select)) { ?>
						<td><?php echo $result[0] ?></td>
						<td><?php echo $result[1] ?></td>
						<td><?php echo $result[5] ?></td>
						<td><?php echo $result[3] ?></td>
						<td><?php echo $result[4] ?></td>
						
						
						<td><?php echo $result[7] ?></td>
						<td><?php echo $result[8] ?></td>
						
					</tr>
			</tbody>
					<?php } ?>



			

		</table>
	</div>


</body>
</html>