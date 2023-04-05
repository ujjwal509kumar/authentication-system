<?php
require('connect.php');
session_start();
// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
	// Redirect the user to the login page
	header('Location: login.html');
	exit;
}
?>
<?php
$user_name = $_SESSION['u_name'];
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
    <title>Support Us</title>
    <meta name="description" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://img.freepik.com/free-vector/support-typographic-header-idea-web-page-diagnostic-service-providing-web-site-with-updated-technical-information-flat-vector-illustration_613284-2889.jpg?w=1380&t=st=1680380754~exp=1680381354~hmac=d2f6254e80f471efc10e448113fc3fbda488f04fa02c47fe3bc099c69b9c8eec"
                        class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form>
                        <!-- Email input -->
                        <p>Please Fill the  form to Support Us</p>
                        <div class="form-outline mb-4">
                            Username
                            <input type="text" name="username" id="username" value="<?php echo "$user_name"; ?>" class="form-control form-control-lg"
                                autocomplete="off" disabled />
                        </div>
                        <div class="form-outline mb-4">
                            Name
                            <input type="text" name="name" id="name" class="form-control form-control-lg"
                                autocomplete="off" />
                        </div>
                        <div class="form-outline mb-4">
                            Amount
                            <input type="number" name="amt" id="amt" class="form-control form-control-lg"
                                autocomplete="off" />
                        </div>
                        <!-- Submit button -->
                        <input type="button" name="btn" id="btn" value="Pay Now" onclick="pay_now()" />
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function pay_now() {
            var username =jQuery('#username').val();
            var name = jQuery('#name').val();
            var amt = jQuery('#amt').val();

            jQuery.ajax({
                type: 'post',
                url: 'payment_processrazor.php',
                data: "amt=" + amt + "&name=" + name + "&username=" + username,
                success: function (result) {
                    var options = {
                        "key": "", // Enter the Key ID generated from the Dashboard
                        "amount": amt * 100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                        "currency": "INR",
                        "name": "", //your business name
                        "description": "",
                        "image": "https://img.freepik.com/free-vector/helping-partner-concept-illustration_114360-8867.jpg?t=st=1680419639~exp=1680420239~hmac=8ab1800342262e6ebf46575f3a304bd773b3e1be49f241846311632edd9d9db3",
                        //"order_id": "order_9A33XWu170gUtm", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                        "handler": function (response) {
                            jQuery.ajax({
                                type: 'post',
                                url: 'payment_processrazor.php',
                                data: "payment_id=" + response.razorpay_payment_id,
                                success: function (result) {
                                    window.location.href = "thankyourazor.php";
                                }
                            });
                        }//,
                        // "prefill": {
                        //     "name": "abc", //your customer's name
                        //     "email": "abc.kumar@example.com",
                        //     "contact": "1234567890"
                        // },
                        // "notes": {
                        //     "address": "Razorpay Corporate Office"
                        // },
                        // "theme": {
                        //     "color": "#3399cc"
                        // }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                    rzp1.on('payment.failed', function (response) {
                        alert(response.error.code);
                        alert(response.error.description);
                        alert(response.error.source);
                        alert(response.error.step);
                        alert(response.error.reason);
                        alert(response.error.metadata.order_id);
                        alert(response.error.metadata.payment_id);
                    });
                }
            });

        };
    </script>
</body>

</html>