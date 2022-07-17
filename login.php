<?php
session_start();
require_once 'my_func.php';
//$user= users::getInstance();

if($user->check_auth()){
    header("Location: dashboard.php");
}?>


<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <title>Login | Point of sale</title>

    <style>
    body {
        display: grid;
        place-items: center;
        padding-top: 50px;
        color: #376075;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        background: #f5f5f5;
    }

    a {
        color: #E58B53
    }

    #wrapper {
        width: 440px;
        padding: 20px;
        margin: 0 auto;
    }

    #box-login {
        border: solid 1px #107C95;
        border-radius: 4px;
        padding: 20px;
        background: #fff;
    }

    #box-login h3>span {
        letter-spacing: 0;
        font-size: 21px;
        display: block;
        font-weight: normal;
    }

    input[type="submit"] {
        cursor: pointer;
        background: #1A80E6;
        border: none;
        color: #f5f5f5;
        border-radius: 5px;
        padding: 10px 0;
    }

    h3 {
        color: #212121;
        margin-top: 0;
        padding-left: 20px;
        font-size: 28px;
    }

    #head-log {
        padding: 4px;
    }

    form {
        padding: 6px 20px 20px 20px;
    }

    #head-log img {
        float: left;
        display: inline;
        width: 90px;
        padding-right: 20px;
    }

    .scanner h3 {
        position: absolute;
        color: #C4C4C4;
    }

    .scanner h3:before {
        content: "Login...";
        position: absolute;
        top: 0;
        left: 20px;
        width: 0;
        height: 100%;
        border-right: 4px solid #1A80E6;
        overflow: hidden;
        color: #1A80E6;
        animation: load 5s linear infinite;
    }

    @keyframes load {

        0%,
        100% {
            width: 0;
        }

        60%,
        80% {
            width: 100%;
        }
    }

    .input-container {
        width: 326px;
        position: relative;
    }

    .label {
        position: absolute;
        left: 10px;
        top: 14px;
        transition: all 0.2s;
        padding: 0 2px;
        z-index: 1;
        color: #808080;
    }

    .text-input {
        padding: 0.8rem;
        width: 100%;
        height: 15px;
        border: 1.5px solid #808080;
        border-radius: 6px;
        font-size: 18px;
        outline: none;
        transition: all 0.3s;
        color: black;
    }

    .label::before {
        content: "";
        height: 5px;
        position: absolute;
        left: 0px;
        top: 10px;
        width: 100%;
        z-index: -1;
    }

    .text-input:focus {
        border: 2px solid #1A80E6;
        color: #1A80E6;
    }

    .text-input:focus+.label,
    .filled {
        top: -10px;
        background: white;
        color: #1A80E6;
        font-size: 14px;
    }

    .text-input::placeholder {
        font-size: 16px;
        opacity: 0;
        transition: all 0.3s;
    }

    .text-input:focus::placeholder {
        opacity: 1;
    }

    .btn {
        border-radius: 45px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.1s ease;
    }

    .btn:hover {
        background: #4DA6FF;
        text-transform: uppercase;
        font-weight: bold;
        box-shadow: 0px 10px 25px #B3E5D3;
        transform: translateY(-5px);
    }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.19/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <div id="wrapper">
        <div id="box-login">
            <div id="head-log">
                <div class="scanner">
                    <h3>Login...</h3>
                </div>
                <div style="margin-top:40px;padding-left:20px">
                    <p style="font-size:15px">Silahkan login untuk masuk ke system point of sale!</p>
                </div>
            </div>
            <?php 
              if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                  echo "<script>Swal.fire({icon: 'error',title: 'Login Gagal',text: 'Silahkan ketikkan ulang username dan password'})</script>";
                }else if($_GET['pesan'] == "logout"){
                  echo "<script>const Toast = Swal.mixin({toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true, didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'warning',
                    title: 'logout Berhasil'
                })</script>";
                }
              }
              ?>
            <form method="post" action="authenticate.php">
                <div class="input-container">
                    <input name="username" value="" class="text-input" id="username" type="text" autocomplete="off" />
                    <label class="label" for="username">username</label>
                </div><br>
                <div class="input-container">
                    <input name="pass" id="password" value="" class="text-input" type="password" autocomplete="off" />
                    <label class="label" for="password">password</label>
                </div>
                <div>
                    <input type="submit" value="Login" class="btn" style="margin-top: 10px; width: 100%">
                </div>
            </form>


        </div>
        <br>
    </div>

    <script>
    document.querySelectorAll(".text-input").forEach((element) => {
        element.addEventListener("blur", (event) => {
            if (event.target.value != "") {
                event.target.nextElementSibling.classList.add("filled");
            } else {
                event.target.nextElementSibling.classList.remove("filled");
            }
        });
    });
    </script>

</body>

</html>
