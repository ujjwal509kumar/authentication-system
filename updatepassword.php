<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update New Password</title>
</head>

<body>
    <?php
    require("connect.php");
    if (isset($_GET['email']) && isset($_GET['reset_token'])) {
        date_default_timezone_set("America/New_York");
        $date = date("Y-m-d");
        $query = "SELECT * FROM `testing` WHERE `email`='$_GET[email]' AND `resettoken`='$_GET[reset_token]' AND `tokenexpiry`='$date'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                echo " 
                <form method='POST' action='kyakrumai.php'>
                <h3>Create New Password </h3>
                <input type='password' placeholder='New Password' name='Password'>
                <input type='hidden' name='email' value='$_GET[email]'>
                <button type='submit' name='updatepassword'>UPDATE</button>
                </form>
                ";
            } else {
                echo "
            <script>
            alert('The Link is Invalid or Expired. Please try re-setting the password again');
            window.location.href='forgot.html'
            </script>
            ";
            }
        } else {
            echo "
            <script>
            alert('Some critical error.Please try contacting admin');
            window.location.href='forgot.html'
            </script>
            ";
        }
    }
    ?>
</body>

</html>