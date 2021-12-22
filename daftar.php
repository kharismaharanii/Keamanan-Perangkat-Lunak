<?php
require 'functions.php';


// try {
//     if (isset($_POST["daftar"])) {
//         if (daf($_POST) > 0) {
//             echo "<script>
//             alert('Pengguna baru berhasil ditambahkan');
//             window.location.href = 'index.php';
//             </script>";
//         } else {
//             echo mysqli_error($conn);
//         }
//     }
// } catch (Error $e) {
//     echo "Error caught: " . $e->getMessage();
// }


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/OAuth.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/POP3.php';
require 'PHPMailer/src/SMTP.php';

// $email = $_POST['email'];
// $nama = $_POST['nama'];
// $password = $_POST['password'];
// $password = password_hash($password, PASSWORD_DEFAULT);
// $code = md5($email . date('Y-m-d'));

$username = strtolower(stripslashes($_POST["unamedaftar"]));
$password = $_POST["pswdaftar"];
$password2 = $_POST["pswdaftar2"];
$level = $_POST["level"];
$email = $_POST["email"];
$code = md5($email . date('Y-m-d'));

$sql = "SELECT * FROM user where email='$email'";
$query = mysqli_query($conn, $sql);

if ($password !== $password2) {
    echo "<script>
                alert('Konfirmasi password tidak sesuai!');
                window.location.href = 'index.php';
            </script>";
    return false;
}

if (mysqli_num_rows($query) > 0) {
    echo "<script>
    alert('Email sudah terdaftar');
    window.location.href = 'index.php';
    </script>";
} else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user (username,password,level, email, verif_code) VALUES('$username','$password','$level','$email','$code')";
    $query = mysqli_query($conn, $sql);

    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // SMTP::DEBUG_OFF = off (for production use)
    // SMTP::DEBUG_CLIENT = client messages
    // SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    // $mail->Port = 465;

    $mail->SMTPSecure = 'ssl';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;

    //Set the encryption mechanism to use - STARTTLS or SMTPS
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = 'mywebkpl@gmail.com';

    //Password to use for SMTP authentication
    $mail->Password = 'mywebkpl123_';

    //Set who the message is to be sent from
    $mail->setFrom('no-reply@yourwebsite.com', 'My Web KPL');

    //Set an alternative reply-to address
    //$mail->addReplyTo('replyto@example.com', 'First Last');

    //Set who the message is to be sent to
    $mail->addAddress($email, $username);

    //Set the subject line
    $mail->Subject = 'Verification Account - My Web KPL';

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $body = "Hi, " . $username . "<br>Please verif your email before access our website : <br> http://localhost:8080/kpl/confirmEmail.php?code=" . $code;
    $mail->Body = $body;
    //Replace the plain text body with one created manually
    $mail->AltBody = 'Verification Account';

    //send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "<script>
        alert('Registrasi berhasil, cek email untuk verifikasi akun');
        window.location.href = 'index.php';
        </script>";
        //Section 2: IMAP
        //Uncomment these to save your message in the 'Sent Mail' folder.
        #if (save_mail($mail)) {
        #    echo "Message saved!";
        #}
    }
}
