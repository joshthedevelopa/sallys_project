<?php
include_once "models/session.php";

if (Session::isset()) {
    header("Location: home.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>System Login</title>

    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicon.ico">

    <link href="assets/lib/lib.css" rel="stylesheet" type="text/css">
    <link href="assets/css/main.css?ver=<?= time() ?>" rel="stylesheet" type="text/css">

    <style>
        body {
            width: 100vw;
            height: 100vh;
            background-color: var(--main-color);
        }

        #login-container {
            position: relative;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            height: fit-content;
            padding: var(--spacing);
            text-align: center;
        }

        #login-container h2 {
            margin-top: var(--spacing);
            color: var(--main-color)
        }

        #login-container h3 {
            margin-top: var(--spacing);
            color: var(--light-text-color)
        }
    </style>
</head>

<body>
    <div id="loading-indicator">
        <div class="indicator"></div>
        <div class="indicator"></div>
    </div>
    <div id="login-container" class="card">

        <img src="assets/img/dalex.png" width="300" , height="120">

        <h2>Login</h2>

        <h3>Authenticate your credentials to be given access to this platform</h3>
        <form id="login">
            <div class="card input-container">
                <div class="custom-input">
                    <div class="icon">
                        <i class="fa fa-sm fa-user"></i>
                    </div>
                    <input name="username" placeholder="Enter in username">
                </div>
            </div>

            <div class="card input-container">
                <div class="custom-input">
                    <div class="icon">
                        <i class="fa fa-sm fa-lock"></i>
                    </div>
                    <input type="password" name="password" placeholder="Enter in password">
                </div>
            </div>
            
            <div class="btn btn-primary data-holder-action" action="login">Authorize</div>
        </form>

    </div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/lib/sweetalert/sweetalert.js"></script>
<script type="module" src="assets/js/main.js?ver=<?= time() ?>"></script>

</html>