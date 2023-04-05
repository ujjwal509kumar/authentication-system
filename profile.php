<?php
require('connect.php');
session_start();
// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// Redirect the user to the login page
	header('Location: login.html');
	exit;
}

// Get the user's ID from the session variable
$user_id = $_SESSION['user_id'];

// Retrieve the user's details from a database 
$stmt = $conn->prepare('SELECT name, username, email, password, status, signup_time, activation_code FROM testing WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($name, $username, $email, $password, $status, $signup_time, $activation_code);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Profile Page</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<setion>
		<div class="container px-5 py-24 mx-auto">
			<div class="flex flex-col text-center w-full mb-20">
				<h2 class="text-xs text-indigo-500 tracking-widest font-medium title-font mb-1">Welcome to Profile Page
				</h2>
				<h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900">This is all we Know about you</h1>
			</div>
	</setion>
	<section class="text-gray-600 body-font relative">
		<div class="container px-5 py-10 mx-auto">
			<div class="flex flex-col text-center w-full mb-12">
				<p class="lg:w-2/3 mx-auto leading-relaxed text-base"><strong>Full Name :</strong>
					<?= $name ?>
				</p>
				<p class="lg:w-2/3 mx-auto leading-relaxed text-base pt-2"><strong>User Name :</strong>
					<?= $username ?>
				</p>
				<p class="lg:w-2/3 mx-auto leading-relaxed text-base pt-2"><strong>Email :</strong>
					<?= $email ?>
				</p>
				<p class="lg:w-2/3 mx-auto leading-relaxed text-base pt-2"><strong>Account Status :</strong>
					<?= $status ?>
				</p>
				<p class="lg:w-2/3 mx-auto leading-relaxed text-base pt-2"><strong>Account Creation Time :</strong>
					<?= $signup_time ?>(According to American Standard Time)
				</p>
				<p class="lg:w-2/3 mx-auto leading-relaxed text-base pt-2"><strong>Account Activation Code :</strong>
					<?= $activation_code ?>
				</p>
				<p class="lg:w-2/3 mx-auto leading-relaxed text-base pt-5"><strong>Fun Fact : </strong>To accept
					donations, we've integrated RazorPay into our website. Developement for Contributions are still in
					the development stage, so no money will be deducted from your account while donating us. Donate us
					and have some fun 😉.
				</p>
			</div>
			<div class="flex justify-center">
				<a href='supportus.php'><button
						class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Donate
						Us</button></a>
				<a href='logout.php'><button
						class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Logout</button></a>
			</div>
		</div>
	</section>
</body>

</html>