<?php
$conn = mysqli_connect("localhost", "root", "", "kpl");

// function daf($data)
// {
//     global $conn;

//     $username = strtolower(stripslashes($data["unamedaftar"]));
//     $password = mysqli_real_escape_string($conn, $data["pswdaftar"]);
//     $password2 = mysqli_real_escape_string($conn, $data["pswdaftar2"]);
//     $level = mysqli_real_escape_string($conn, $data["level"]);
//     $email = mysqli_real_escape_string($conn, $data["email"]);
//     $code = md5($email . date('Y-m-d'));

//     //cek double username
//     $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
//     if (mysqli_fetch_assoc($result)) {
//         echo "<script>
//             alert('Username sudah terdaftar');
//             window.location.href = 'index.php';
//         </script>";
//         return false;
//     }


//     //konfirmasi
//     if ($password !== $password2) {
//         echo "<script>
//             alert('Konfirmasi password tidak sesuai!');
//             window.location.href = 'index.php';
//         </script>";
//         return false;
//     }

//     //enkripsi password
//     $password = password_hash($password, PASSWORD_DEFAULT);

//     //masukkan ke database
//     mysqli_query($conn, "INSERT INTO user (username,password,level, email, verif_code) VALUES('$username','$password','$level','$email','$code')");
//     return mysqli_affected_rows($conn);
// }
