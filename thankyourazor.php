<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Thankyou so much</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <?php
    include "connect.php";
    session_start();
    ?>
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center rounded" alt="hero"
                    src="https://media.istockphoto.com/id/1396216349/vector/badge-thank-you.jpg?s=612x612&w=0&k=20&c=w4wpuo-V6scJx0Y0_JNskmupyOj1onAwUCv3eKjkop0=">
            </div>
            <div
                class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Thankyou for your support 💖
                    <br><br class="hidden lg:inline-block">Payment details :
                </h1>
                <?php
                $stmt = $conn->prepare('SELECT username,name, amount, payment_status, payment_id, added_on FROM donations WHERE id = ?');
                $stmt->bind_param('i', $_SESSION['OID']);
                $stmt->execute();
                $stmt->bind_result($username, $name, $amount, $payment_status, $payment_id, $added_on);
                $stmt->fetch();
                $stmt->close();

                ?>
                <p class="my-1 leading-relaxed"><strong>Username : </strong>
                    <?= $username ?>
                </p>
                <p class="my-1 leading-relaxed"><strong>Name : </strong>
                    <?= $name ?>
                </p>
                <p class="my-1 leading-relaxed"><strong>Amount Paid : </strong>₹
                    <?= $amount ?>
                </p>
                <p class="my-1 leading-relaxed"><strong>Payment Status : </strong>
                    <?= $payment_status ?>
                </p>
                <p class="my-1 leading-relaxed"><strong>Payment id : </strong>
                    <?= $payment_id ?>
                </p>
                <p class="my-1 mb-5 leading-relaxed"><strong>Date and time : </strong>
                    <?= $added_on ?>
                </p>
                <div class="flex justify-center">
                <a href='profile.php'><button
                        class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Profile</button></a>
                <a href='logout.php'><button
                        class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Log Out</button></a>
                <button onclick="window.print()"
                        class="ml-4 inline-flex text-gray-700 bg-violet-500 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">Print Recipt</button>
                </div>

            </div>
        </div>
    </section>

</body>

</html>