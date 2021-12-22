<?php
require('functions.php');

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $sql = "SELECT * FROM user where verif_code = '$code'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        $id = $user['id'];
        $sql =  "UPDATE user set is_verified = 1 where id=$id";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo "Verifikasi berhasil, silahkan login";
        } else {
            echo "Verivikasi gagal : " . $query;
        }
    } else {
        echo "Code verifikasi tidak ditemukan";
    }
} else {
    echo "Terdapat kesalahan";
}
