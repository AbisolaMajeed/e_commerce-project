<?php 
	session_start();
	include("../db/db_config.php");
	include('../db/authenticate.php');
	aut_admin();
	$admin_name = $_SESSION['administrator_name'];
	$select = mysqli_query($db,"SELECT * FROM customers") or die(mysqli_error($db));
	
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Registered |Customers</title>
 	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/home.css">
	<link rel="stylesheet" type="text/css" href="../css/table.css">
 </head>
 <body>
 	<header>
		<h1>
			Registered Customers Page
		</h1>
		<nav>
			<a href="admin_home.php">Admin Home</a>
			<a href="logout.php">Click to Logout</a>
		</nav>

	</header>
		<div class="table">
	

		<table border="1" class="content-table">
			<?php
				echo "<p>Current Admin: <strong>$admin_name</strong></p>";
			
			?>
			<thead>
				<tr>
					<th>S/N</th>
					<th>Name</th>
					<th>Email</th>
					<th>Address</th>
					<th>Phone Number</th>

				</tr>
			</thead>
			<tbody>
			<tr>
				
				<?php while($result = mysqli_fetch_array($select)) { ?>
						<td><?php echo $result[0] ?></td>
						<td><?php echo $result[1]." ".$result[2] ?></td>
						<td><?php echo $result[4] ?></td>
						<td><?php echo $result[3] ?></td>
						<td><?php echo $result[5] ?></td>						
					</tr>
			</tbody>
					<?php } ?>



			

		</table>
 </body>
 </html>