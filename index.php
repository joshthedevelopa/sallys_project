<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="assets/lib/lib.css" rel="stylesheet" type="text/css">
    <link href="assets/css/main.css?ver=<?= time() ?>" rel="stylesheet" type="text/css">

    <title>Document</title>
</head>
<body>
    <section id="sidebar">
        <div class="logo">ssssssss</div>
        <ul class="tab-nav">
            <li class="navigation-btn" target="dashboard"><i class="fa fa-sm fa-users"></i> <span>Dashboard</span></li>
            <li class="navigation-btn" target="customer"><i class="fa fa-sm fa-user"></i> <span>Customers</span></li>
            <li class="navigation-btn" target="recovery"><i class="fa fa-sm fa-database"></i> <span>Recovery</span></li>
            <li class="navigation-btn" target="setting"><i class="fa fa-sm fa-cog"></i> <span>Setting</span></li>
        </ul>
    </section>
    <section id="main">
        <header>
            <div id="header-search">
                <div class="custom-input">
                    <div class="icon">
                        <i class="fa fa-sm fa-search"></i>
                    </div>
                    <input></input>
                </div>
            </div>
            <div id="header-icons">
                <div>
                    <i class="fa fa-sm fa-bell"></i>
                </div>
                <div>
                    <i class="fa fa-sm fa-user"></i>
                </div>
            </div>
        </header>
        <main>
            <div id="loading-indicator">
                <div class="indicator"></div>
                <div class="indicator"></div>
            </div>
            <div id="content">
                <?php include_once 'views/dashboard.php' ?>
            </div>
        </main>
    </section>
</body>
<script src="assets/js/jquery.min.js"></script>

<!-- Libraries -->
<script src="assets/lib/datatables/datatables.js"></script>
<script src="assets/lib/sweetalert/sweetalert.js"></script>

<!-- Custom -->
<script type="module" src="assets/js/main.js?ver=<?= time() ?>"></script>

</html>