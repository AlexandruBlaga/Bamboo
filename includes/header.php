<?php
	require 'config/config.php';

	if(isset($_SESSION['username']))
	{
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
		$user = mysqli_fetch_array($user_details_query);
	}
	else
	{
		header("Location: register.php");
	}
?>
<html>
<head>
	<title>Bamboo</title>
	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>

	<!-- CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>
		<div class="top-bar">
			
				<div class='logo'>
					<a href="index.php"><img src="assets/images/logos/logo2.png"></a>
				</div>

					<nav>
						<a href="<?php echo $userLoggedIn; ?>">
							<?php echo $user['first_name']; ?>
						</a>
						<a href="#">
							<i class="fa fa-home fa-lg"></i>
						</a>
						<a href="#">
							<i class="fa fa-envelope fa-lg"></i>
						</a>
						<a href="#">
							<i class="fa fa-bell fa-lg"></i>
						</a>
						<a href="#">
							<i class="fa fa-users fa-lg"></i>
						</a>
						<a href="#">
							<i class="fa fa-cog fa-lg"></i>
						</a>
						<a href="includes/handlers/logout.php">
							<i class="fa fa-sign-out-alt fa-lg"></i>
						</a>
					</nav>
				</div>
	

	<div class="wrapper">
