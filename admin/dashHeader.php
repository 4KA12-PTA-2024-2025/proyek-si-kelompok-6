<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard Warung Boboko</title>
    <link href="../css/admin.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Brand-->
        <a href="orders-panel.php" class="navbar-brand ps-3">Warung Boboko</a>

    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Main</div>
                        <a class="nav-link" href="../admin/orders-panel.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                            Pesanan
                        </a>
                        <a class="nav-link" href="../admin/menu-panel.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-utensils"></i></div>
                            Menu
                        </a>
                        <a class="nav-link" href="../admin/account-panel.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-eye"></i></div>
                            Lihat Semua Akun
                        </a>
                        <a class="nav-link" href="../admin/logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        </<div>
        <div id="content-for-template">Content</div>

        <script src="../js/scripts.js" type="text/javascript"></script>