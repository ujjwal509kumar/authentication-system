<?php
require("connect.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require __DIR__.'/vendor/autoload.php';
function sendMail($email, $reset_token)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = ''; //SMTP username
        $mail->Password = ''; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $mail->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('', 'Password Change Request From Login Portal'); //write your email here
        $mail->addAddress($email); //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Reset Your Account Password';
        $mail->Body = " Hello There,  <br> <br> <br>
                        We See That You Made A Password Change Request! If It Was Really You,Click Below! To Reset Your Password,<br><br><center>
                        <a href='http://yourwebsite/updatepassword.php?email=$email&reset_token=$reset_token'> Reset Password </a> </center> <br>
                         Above Link Not Working? just Copy And Paste The Below Link In Your Favourite Browser:
                         <p>http://yourwebsite/updatepassword.php?email=$email&reset_token=$reset_token</p>  <br><br><br><br>

                       If You Did Not Initiate This Request DON't DO ANYTHING STUPID. LIKE, CLICKING ON THE LINK/THE BUTTON ABOVE<br>
                       
                       Believe You Did Not Make This Request?  <br> Don't Panic/Don't Curse Any Of Our Developer's/Don't Try To Delete Your Account/Don't Think Your Data is Un-Safe (Between If You Are A Real Human You'r Data Is Probablly Already On Web).
                       <br><center><b><u>OR<u><b></center><br>
                       Just Mail To Us on <center><b><u>Your email<u><b></center> <b> We Will Investigate And Take The Best Course Of Action. <br><br>AGAIN YOUR DATA IS ABSOLUTELLY SAFE WITH US.WE ARE NOT FOOL TO GIVE YOUR DATA FOR FREE....</b>";

        $mail->AltBody = 'yeah we have sent you an password reset link (you are seeing this text as you are non-html customer)';
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
if (isset($_POST['send-link-mail'])) {
    $query = "SELECT * FROM `testing` WHERE `email`='$_POST[email]'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set("America/New_York");
            $date = date("Y-m-d");
            $query = "UPDATE `testing` SET `resettoken`='$reset_token',`tokenexpiry`='$date' WHERE `email`='$_POST[email]'";
            if (mysqli_query($conn, $query) && sendMail($_POST['email'], $reset_token)) {
                echo "
            <script>
            alert('We have sent an Password Reset Link To Your Inbox.SPAM TOO.');
            window.location.href='login.html'
            </script>
            ";
            } else {
                echo "
            <script>
            alert('Ahhhh, CRAPP!! Something Went Wrong, try again later');
            window.location.href='forgot.html'
            </script>
            ";
            }
        } else {
            echo "
            <script>
            alert('We Are Really Not Dumb. So,First Register Yourself Dude!');
            window.location.href='forgot.html'
            </script>
            ";
        }
    } else {
        echo "
        <script>
        alert('Yeah This Error Is On Us!. So,Chill We Will Fix It ASAP And Try Again Later.');
        window.location.href='forgot.html'
        </script>
        ";
    }
}
?>