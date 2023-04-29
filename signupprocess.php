<?php

include "connect.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['g-recaptcha-response'])) {
    $secreatkey = "";//enter your server side integration key
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secreatkey&response=$response&remoteip=$ip";
    $content = file_get_contents($url);
    $data = json_decode($content);
    if ($data->success == true) {
        // SINGUP PROCESS CODE 
        $otp_str = str_shuffle("0123456789");
        $otp = substr($otp_str, 0, 5);

        $act_str = rand(100000, 10000000);
        $activation_code = str_shuffle("abcdefghijklmno" . $act_str);


        if (isset($_POST['register'])) {

            $otp = $_POST['otp'];
            $activation_code = $_POST['activation_code'];
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password1 = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password1, PASSWORD_DEFAULT);
        
        
            $selectUsername = "SELECT * FROM testing WHERE username = '" . $username . "'";
            $selectUserResult = mysqli_query($conn, $selectUsername);
            $selectRow = mysqli_fetch_assoc($selectUserResult);
            echo $status = $selectRow['status'];
            if (mysqli_num_rows($selectUserResult) > 0 && ($status == 'active')) {
                echo "<script>
                alert('This Username is already taken, So please randomize your username');
                window.location.href='index.php';
                </script>";
                exit;
            }
        
            $selectDatabase = "SELECT * FROM testing WHERE email = '" . $email . "'";
            $selectResult = mysqli_query($conn, $selectDatabase);
            if (mysqli_num_rows($selectResult) > 0) {
        
                $selectRow = mysqli_fetch_assoc($selectResult);
        
                echo $status = $selectRow['status'];
        
                if ($status == 'active') {
        
                    echo "<script>
                    alert('Email already registered');
                    window.location.href='index.php'
                    </script>";
                } else {
        
                    $sqlUpdate = "UPDATE testing SET name = '" . $name . "', username = '" . $username . "', password = '" . $password . "', otp = '" . $otp . "', activation_code = '" . $activation_code . "'";
                    $updateResult = mysqli_query($conn, $sqlUpdate);
        
                    if ($updateResult) {
        
                        // require 'class/class.phpmailer.php';
                        require 'vendor/autoload.php';
        
                        $mail = new PHPMailer;
                        $mail->IsSMTP();
                        // $mail->Host = 'smtp.sendgrid.net';
                        $mail->Host = 'smtp.gmail.com';
                        // $mail->Port = '587';
                        $mail->Port = 465;
                        $mail->SMTPAuth = true;
                        // $mail->Username = 'apikey';
                        $mail->Username = 'ujjwal509kumar@gmail.com';
                        // $mail->Password = 'your smtp apikey or password here';
                        $mail->Password = 'cswgatywmmgvvijb';
                        // $mail->SMTPSecure = 'TLS';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                        // $mail->From = 'your mail here';
                        $mail->From = 'ujjwal509kumar@gmail.com';
                        // $mail->FromName = 'Singup Confirmation';
                        $mail->setFrom('ujjwal509kumar@gmail.com', 'OTP Verification for website');
                        $mail->AddAddress($email);
                        $mail->WordWrap = 50;
                        $mail->IsHTML(true);
                        $mail->Subject = 'Verification code for Verify Your Email Address';
        
                        $message_body = '
                        <p>For verify your email address, enter this verification code : <b>' . $otp . '</b>.</p>
                        <p>Sincerely,</p>
                        ';
                        $mail->Body = $message_body;
        
                        if ($mail->Send()) {
                            echo '<script>alert("Please Check Your Email for Verification Code")</script>';
                            header('Refresh:1; url=email_verify.php?code=' . $activation_code);
                        } else {
                            $message = $mail->ErrorInfo;
                            echo '<script>alert("' . $message . '")</script>';
                        }
                    }
        
                }
            } else {
        
                // require 'class/class.phpmailer.php';
                require 'vendor/autoload.php';
                $mail = new PHPMailer;
                $mail->IsSMTP();
                // $mail->Host = 'smtp.sendgrid.net';
                $mail->Host = 'smtp.gmail.com';
                // $mail->Port = '587';
                $mail->Port = 465;
                $mail->SMTPAuth = true;
                // $mail->Username = 'apikey';
                $mail->Username = 'ujjwal509kumar@gmail.com';
                // $mail->Password = 'your smtp apikey or password here';
                $mail->Password = 'cswgatywmmgvvijb';
                // $mail->SMTPSecure = 'TLS';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                // $mail->From = 'your mail here';
                $mail->From = 'ujjwal509kumar@gmail.com';
                // $mail->FromName = 'Singup Confirmation';
                $mail->setFrom('ujjwal509kumar@gmail.com', 'OTP Verification for website');
                $mail->AddAddress($email);
                $mail->WordWrap = 50;
                $mail->IsHTML(true);
                $mail->Subject = 'Verification code for Verify Your Email Address';
        
                $message_body = '
                <p>For verify your email address, enter this verification code : <b>' . $otp . '</b>.</p>
                <p>Sincerely,</p>
                ';
                $mail->Body = $message_body;
        
                if ($mail->Send()) {
                    $sqlInsert = "INSERT INTO testing (name, username, email, password, otp, activation_code) VALUES ('" . $name . "', '" . $username . "', '" . $email . "', '" . $password . "', '" . $otp . "', '" . $activation_code . "')";
                    $insertResult = mysqli_query($conn, $sqlInsert);
        
                    if ($insertResult) {
        
                        echo '<script>alert("Please Check Your Email for Verification Code")</script>';
                        header('Refresh:1; url=email_verify.php?code=' . $activation_code);
                    } else {
                        echo '<script>alert("Opss something wrong failed to insert data")</script>';
                    }
                } else {
                    $message = $mail->ErrorInfo;
                    echo '<script>alert("' . $message . '")</script>';
                }
            }
        
        }// End of Singup Process
    } else {
        echo"<script>
            alert('Please fill the recaptcha form and try again.');
            window.location.href='index.php'
            </script>";
    }
} else {
    echo "<script>
            alert('Problem in recaptcha please contact admin');
            window.location.href='index.php'
            </script>";
}
?>
