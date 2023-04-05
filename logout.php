<?php
session_start();

// Clear the logged_in session variable
unset($_SESSION['logged_in']);

// Redirect the user to the login page
header('Location: login.html');
exit;
?>