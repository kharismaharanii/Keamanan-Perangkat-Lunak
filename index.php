<?php
session_start();
require 'functions.php';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link href="img/logo.png" rel="shortcut icon">
    <title>To-Do List</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <div style="color:#86340A ;">
                <h3><b><img src="img/logo.png" style="height: 80px;"> To-Do List</b></h3>
            </div>
            <div style="float: right;">
                <button onclick="document.getElementById('id02').style.display='block'" style="width:auto; background-color:#86340A">Daftar</button>
                <button onclick="document.getElementById('id01').style.display='block'" style="width:auto; background-color:#86340A">Login</button>
            </div>
        </div>
    </nav>

    <!-- login -->
    <div id="id01" class="modal">
        <form class="modal-content animate" action="login.php" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <center>
                    <label><b>
                            <h4>LOGIN</h4>
                        </b></label><br>
                </center>

                <label for="unamelogin"><b>Username</b></label>
                <input type="text" placeholder="Masukkan Username" name="unamelogin" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Masukkan Password" name="psw" required>

                <button type="submit" name="login" href="login.php">Submit</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="requestReset.php">password?</a></span>
            </div>
        </form>
    </div>

    <!-- daftar -->
    <div id="id02" class="modal">
        <form class="modal-content animate" action="daftar.php" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <center>
                    <label><b>
                            <h4>DAFTAR</h4>
                        </b></label><br>
                </center>

                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Masukkan Email" name="email" required>

                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Masukkan Username" name="unamedaftar" required>

                <label for="pswdaftar"><b>Password</b></label>
                <input type="password" placeholder="Masukkan Password" name="pswdaftar" required>

                <label for="pswdaftar2"><b>Konfirmasi Password</b></label>
                <input type="password" placeholder="Masukkan Password" name="pswdaftar2" required>

                <label for="level"><b>Hak Akses</b></label>
                <select class="form-select" aria-label="Default select example" name="level">
                    <option selected value="user">User</option>
                </select>

                <button type="submit" name="daftar">Submit</button>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
        </form>
    </div>

    <script src="kode-script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>

</html>