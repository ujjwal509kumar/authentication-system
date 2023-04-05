<?php
include "connect.php";

date_default_timezone_set("America/New_York");

if (isset($_POST['verify'])) {

	if (isset($_GET['code'])) {

		$activation_code = $_GET['code'];
		$otp = $_POST['otp'];

		$sqlSelect = "SELECT * FROM testing WHERE activation_code = '" . $activation_code . "'";
		$resultSelect = mysqli_query($conn, $sqlSelect);
		if (mysqli_num_rows($resultSelect) > 0) {

			$rowSelect = mysqli_fetch_assoc($resultSelect);

			$rowOtp = $rowSelect['otp'];
			$rowSignupTime = $rowSelect['signup_time'];

			$signupTime = date('d-m-Y h:i:s', strtotime($rowSignupTime));
			$signupTime = date_create($signupTime);
			date_modify($signupTime, "+15 minutes");
			$timeUp = date_format($signupTime, 'd-m-Y h:i:s');

			if ($rowOtp !== $otp) {
				echo "<script>alert('Please provide correct OTP..!')</script>";
			} else {
				if (date('d-m-Y h:i:s') >= $timeUp) {

					echo "<script>alert('Your time is up..try it again..!')</script>";
					header("Refresh:1; url=login.html");
					exit;
				} else {
					$sqlUpdate = "UPDATE testing SET otp = '', status = 'active' WHERE otp = '" . $otp . "' AND activation_code = '" . $activation_code . "'";
					$resultUpdate = mysqli_query($conn, $sqlUpdate);

					if ($resultUpdate) {

						echo "<script>alert('Your account successfully activated')</script>";
						header("Refresh:1; url=login.html");
					} else {
						echo "<script>alert('Opss..Your account not activated')</script>";
					}
				}
			}

		} else {
			header("Location: index.php");
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Meta Tags -->
	<meta charset="UTF-8">
	<meta name="author" content="Ujjwal Kumar">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Site Title -->
	<title>PHP Signup with OTP Email Verification System</title>
	<!-- External Style Sheet -->
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

</head>

<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
		crossorigin="anonymous">
    </script>
	<section class="vh-100">
		<div class="container py-5 h-100">
			<div class="row d-flex align-items-center justify-content-center h-100">
				<div class="col-md-8 col-lg-7 col-xl-6">
					<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
						class="img-fluid" alt="Phone image">
				</div>
				<div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
					<form action="" method="POST">
						<!-- Email input -->
						<p>Please enter the otp</p>
						<div class="form-outline mb-4">
							<input type="text" name="otp" class="form-control form-control-lg" autocomplete="off"/>
						</div>
						<!-- Submit button -->
						<button type="submit" name="verify" value="Verify" class="btn btn-primary btn-lg btn-block">Continue</button>
					</form>
				</div>
			</div>
		</div>
	</section>
</body>
</html>