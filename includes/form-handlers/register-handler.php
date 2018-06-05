<?php
	
	$fname = "";
	$lname = "";
	$em = "";
	$em2 = "";
	$pw = "";
	$pw2 = "";
	$date = "";
	$error_array = array();

	if(isset($_POST['register_button']))
	{
		// registration form values

		//first name
		$fname = strip_tags($_POST['reg_fname']); // remove tags
		$fname = str_replace(' ', '', $fname); // remove spaces
		$fname = ucfirst(strtolower($fname)); // capitalize only the first letter
		$_SESSION['reg_fname'] = $fname; // stores first name into session variable

		//lirst name
		$lname = strip_tags($_POST['reg_lname']); // remove tags
		$lname = str_replace(' ', '', $lname); // remove spaces
		$lname = ucfirst(strtolower($lname)); // capitalize only the first letter
		$_SESSION['reg_lname'] = $lname;

		//email
		$em = strip_tags($_POST['reg_email']); // remove tags
		$em = str_replace(' ', '', $em); // remove spaces
		$em = ucfirst(strtolower($em)); // capitalize only the first letter
		$_SESSION['reg_email'] = $em;

		//email 2
		$em2 = strip_tags($_POST['reg_email2']); // remove tags
		$em2 = str_replace(' ', '', $em2); // remove spaces
		$em2 = ucfirst(strtolower($em2)); // capitalize only the first letter
		$_SESSION['reg_email2'] = $em2;

		//password
		$password = strip_tags($_POST['reg_password']); // remove tags

		//password2
		$password2 = strip_tags($_POST['reg_password2']); // remove tags

		//date
		$date = date("Y-m-d"); // current date

		if($em == $em2)
		{
			//check if email is in valid format
			if(filter_var($em, FILTER_VALIDATE_EMAIL)) {
				$em = filter_var($em, FILTER_VALIDATE_EMAIL);

				//check if email already exists
				$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

				//count numbers of rows returned
				$num_rows = mysqli_num_rows($e_check);

				if($num_rows > 0)
				{
					array_push($error_array, "Email already in use<br>");
				}
			}
			else
			{
				array_push($error_array, "Invalid email format<br>");
			}
		}
		else
		{
			array_push($error_array, "Emails don't match<br>");
		}

		if(strlen($fname) > 25 || strlen($fname) < 1)
		{
			array_push($error_array, "Your first name must be between 1 and 25 characters<br>");
		}

		if(strlen($lname) > 25 || strlen($lname) < 1)
		{
			array_push($error_array, "Your last name must be between 1 and 25 characters<br>");
		}

		if($password != $password2)
		{
			array_push($error_array, "Your passwords don't match<br>");
		}
		else
		{
			if(preg_match('/[^A-Za-z0-9]/', $password))
			{
				array_push($error_array, "Your password can not contain special characters<br>");
			}
		}

		if(strlen($password > 30) || strlen($password) < 8)
		{
			array_push($error_array, "Your password must be between 8 and 30 characters<br>");
		}

		if(empty($error_array))
		{
			$password = md5($password); // encrypt pw before sending it to db

			// generate username by concatenating first name and last name
			$username = strtolower($fname . "_" . $lname);
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
			$i = 0;
			// if username already exists add number to username
			while(mysqli_num_rows($check_username_query) != 0) {
				$i++;
				$username = $username . "_" . $i;
				$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
			}

			//profile pic assignment
			$rand = rand(1, 2); //creates a random number between 1 and 2

			if($rand == 1)
			{
				$profile_pic = "assets/images/profile-pics/defaults/head_deep_blue.png";
			}
			else if($rand == 2)
			{
				$profile_pic = "assets/images/profile-pics/defaults/head_emerald.png";
			}

			$query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

			array_push($error_array, "<span style='color: #14C800'>You are all set! Go ahead and login!</span><br>");

			//clear session variables
			$_SESSION['reg_fname'] = "";
			$_SESSION['reg_lname'] = "";
			$_SESSION['reg_email'] = "";
			$_SESSION['reg_email2'] = "";

			
		}
	}
 ?>