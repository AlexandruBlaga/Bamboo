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
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<meta charset="utf-8">
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
