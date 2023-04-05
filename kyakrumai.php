<?php
    require("connect.php");
    if (isset($_POST['updatepassword'])) {
        $pass = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        $update = "UPDATE `testing` SET `password`='$pass', `resettoken`=NULL, `tokenexpiry`=NULL WHERE `email`='$_POST[email]'";
        if (mysqli_query($conn, $update)) {
            echo "
            <script>
            alert('Password changed Successfully');
            window.location.href='login.html'
            </script>
            ";
        } else {
            echo "
            <script>
            alert('Server down please try again later !');
            window.location.href='index.php'
            </script>
            ";
        }
    } else {
        echo "
            <script>
            alert('We had some Technical Issues! Try Later Please :)');
            window.location.href='forgot.html'
            </script>
            ";
    }
?>