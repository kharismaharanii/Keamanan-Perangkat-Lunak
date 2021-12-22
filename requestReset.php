<?php
ob_start();
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'functions.php';

if (isset($_POST["email"])) {
    $emailTo = $_POST["email"];
    $code = uniqid(true);
    $username = $_POST["username"];
    $query = mysqli_query($conn, "INSERT INTO resetPasswords(code,email,username) VALUES ('$code','$emailTo', '$username')");

    if (!$query) {
        exit("Error");
    }

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'mywebkpl@gmail.com';                     //SMTP username
        $mail->Password   = 'mywebkpl123_';                               //SMTP password
        $mail->SMTPSecure = 'ssl';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('mywebkpl@gmail.com', 'Web KPL');
        $mail->addAddress($emailTo);     //Add a recipient
        $mail->addReplyTo('no-reply@gmail.com', 'No reply');

        //Content
        $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "/resetPassword.php?code=$code";
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reset Password';
        $mail->Body    = "<h1>Silahkan perbarui password anda</h1>
                            dengan klik <a href='$url'>di sini</a>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo "<script>
        alert('Silahkan periksa Email anda!');
     </script>";
    } catch (Exception $e) {
        echo "Gagal kirim. Mailer Error: {$mail->ErrorInfo}";
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/pass.css">
</head>

<body>
    <div class="login-form" style="margin-top: 140px;">
        <form method="post">
            <h2 class="text-center">Reset Password</h2>
            <div class="form-group ">
                <div class="form-group has-error">
                    <div class="title-menu"><i class="fas fa-envelope"></i> Email Anda : </div>
                    <input type="text" class="form-control" name="email" placeholder="masukkan email anda" required="required">
                </div>
                <div class="form-group has-error">
                    <div class="title-menu"><i class="fas fa-envelope"></i> Username : </div>
                    <input type="text" class="form-control" name="username" placeholder="masukkan username" required="required">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Kirim">
                </div>
        </form>
    </div>
</body>

</html>