<?php
	ob_start(); // turns on output buffering
	session_start();

	$timezone = date_default_timezone_set("Europe/Bucharest");

	$con = mysqli_connect("localhost", "root", "", "intouch"); // connection variable
	if(mysqli_connect_errno())
    {
		echo "Failed to connect: " . mysqli_connect_errno();
	}
?>