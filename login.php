<?php
session_start();
require 'functions.php';
try {
    $username = $_POST['unamelogin'];
    $password = $_POST['psw'];


    $sql = "SELECT * FROM user where username = '$username'";
    $query = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($query);
    if ($user['is_verified'] == 1) {
        if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
            $id = $_COOKIE['id'];
            $key = $_COOKIE['key'];

            //ambil username berdasarkan id
            $result = mysqli_query($conn, "SELECT username from user WHERE id =$id");
            $row = mysqli_fetch_assoc($result);

            //cek cookie dan username
            if ($key === hash('sha256', $row['username'])) {
                $_SESSION['login'] = true;
            }
        }
        if (isset($_SESSION["login"])) {
            header("Location: halamanuser.php");
            exit;
        }

        if (isset($_POST["login"])) {
            $username = $_POST["unamelogin"];
            $password = $_POST["psw"];

            $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

            //cek username
            if (mysqli_num_rows($result) === 1) {

                //cek password
                $row = mysqli_fetch_assoc($result);
                if (password_verify($password, $row["password"])) {
                    //set session
                    $_SESSION["login"] = true;

                    //cek remember me
                    if (isset($_POST['remember'])) {
                        //cookie
                        setcookie('id', $row['id'], time() + 60);
                        setcookie('key', hash('sha256', $row['username']), time() + 60);
                    }

                    //cek level
                    // cek jika user login sebagai admin
                    if ($row['level'] == "admin") {
                        // buat session login dan username
                        $_SESSION['username'] = $username;
                        $_SESSION['level'] = "admin";
                        // alihkan ke halaman dashboard admin
                        header("location:halamanadmin.php");

                        // cek jika user login sebagai user dan telah diverifikasi
                    } else if (($row['level'] === "user")) {
                        // buat session login dan username
                        $_SESSION['username'] = $username;
                        $_SESSION['level'] = "user";

                        $sql = "INSERT INTO user_log(username,waktu)
                        VALUES('$username',now())";
                        $query = mysqli_query($conn, $sql);

                        // alihkan ke halaman dashboard user
                        header("location:halamanuser.php");
                    }
                    // else {
                    //     // alihkan ke halaman login kembali
                    //     header("location:index.php?pesan=gagal");
                    // }
                }
            }
            $error = true;
            if (isset($error)) {
                echo "<script>
                    alert('Username/password salah');
                    window.location.href = 'index.php';
                    </script>";
            }
        }

        //jika belum diverifikasi
    } else {

        echo "<script>
        alert('Maaf, akun belum terverifikasi atau belum daftar');
        window.location.href = 'index.php';
        </script>";
    }
} catch (Error $e) {
    echo "Error caught: " . $e->getMessage();
}
