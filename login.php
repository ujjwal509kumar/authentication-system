<?php
session_start();
require("connect.php");

if (isset($_POST['g-recaptcha-response'])) {
    $secreatkey = "";//your server side integration key here
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secreatkey&response=$response&remoteip=$ip";
    $content = file_get_contents($url);
    $data = json_decode($content);
    if ($data->success == true) {
        // Retrieve the entered email and password from the form data
        $entered_email = $_POST['email'];
        $entered_password = $_POST['password'];
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT password FROM testing WHERE email = ?");
        $stmt->bind_param("s", $entered_email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a row was returned (meaning the email was found in the database)
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password_hash = $row['password'];
            // Compare the entered password to the stored hashed password
            if (password_verify($entered_password, $stored_password_hash)) {
                // Log the user in

                $stmt = $conn->prepare("SELECT id, username FROM testing WHERE email = ?");
                $stmt->bind_param("s", $entered_email);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $uname = $row['username'];
                    $uid = $row['id'];
                }
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $uid;
                $_SESSION['u_name'] = $uname;
                header('Location: profile.php');

            } else {
                // Display an error message
                echo "
        <script>
            alert('Incorrect password. Please try again 🤦‍♂️');
            window.location.href='login.html'
        </script>
        ";
            }
        } else {
            // Display an error message
            echo "
    <script>
            alert('email not found in the database');
            window.location.href='login.html'
    </script>
    ";
        }

        $stmt->close();
        $conn->close();
    } else {

        echo "<script>
        alert('Please fill the reCAPTCH form and try again.');
        window.location.href='login.html'
        </script>";
    }
} else {
    echo "<script>
        alert('reCAPTCHA problem, please contact admin.');
        window.location.href='login.html'
        </script>";
}
?>
