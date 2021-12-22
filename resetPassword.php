<?php
session_start();
include("functions.php");

if (!isset($_GET["code"])) {
    exit("Halaman tidak ditemukan");
}

$code = $_GET["code"];

$getEmailQuery = mysqli_query($conn, "SELECT username FROM resetpasswords WHERE code='$code'");
if (mysqli_num_rows($getEmailQuery) == 0) {
    exit("Halaman tidak ditemukan");
}

if (isset($_POST["password"])) {
    $pw = $_POST["password"];
    $pw = password_hash($pw, PASSWORD_DEFAULT);

    $row = mysqli_fetch_array($getEmailQuery);
    $username = $row["username"];

    $query = mysqli_query($conn, "UPDATE user SET password='$pw' WHERE username='$username'");

    if ($query) {
        $query = mysqli_query($conn, "DELETE FROM resetpasswords WHERE code='$code'");
        echo "<script>
        alert('Password telah diperbarui');
        document.location.href = 'index.php'
     </script>";
    } else {
        echo "<script>
        alert('Terdapat kesalahan');
        document.location.href = 'resetpassword.php'
     </script>";
    }
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
    <div class="login-form">
        <form method="post" style="margin-top: 140px;">
            <h2 class="text-center">Password Baru</h2>
            <div class="form-group ">
                <div class="form-group has-error">
                    <div class="title-menu"><i class="fa fa-key"></i> Password Baru : </div>
                    <input type="password" class="form-control" name="password" placeholder="masukkan password baru anda" required="required">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="Kirim">
                </div>
        </form>
    </div>
</body>

</html>