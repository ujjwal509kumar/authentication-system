<?php
session_start();
include('connect.php');
if (isset($_POST['amt']) && isset($_POST['name'])) {
    $amt = $_POST['amt'];
    $name = $_POST['name'];
    $payment_status="initiated";
    $username = $_POST['username'];
    $added_on = date('Y-m-d h:i:s');

    mysqli_query($conn, "INSERT INTO donations(username, name, amount, payment_status, added_on) values('$username', '$name', '$amt', '$payment_status', '$added_on')");
    $_SESSION['OID'] = mysqli_insert_id($conn);
}


if (isset($_POST['payment_id']) && isset($_SESSION['OID'])) {
    $payment_id = $_POST['payment_id'];

    mysqli_query($conn, "UPDATE donations SET payment_status='success',payment_id='$payment_id' WHERE id='" . $_SESSION['OID'] . "'");
    
}
?>