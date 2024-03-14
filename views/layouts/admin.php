<?php

if (
    session_status() == PHP_SESSION_NONE
) {
    session_start();
}
// Access configuration values from the session
if (isset($_SESSION['appName']) && isset($_SESSION['appUrl'])) {
    $appName = $_SESSION['appName'];
    $appUrl = $_SESSION['appUrl'];
} else {
    // Handle the case where session values are not set
    // You may want to redirect to the index page or set default values
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/abs-design.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/media-query.css" />
    <title><?php echo isset($title) ? $title : 'card-fraud-detection'; ?></title>
    <style>
        .brand-logo {
            width: 100%;
            height: 100%;
            max-height: 50px;
            max-width: 50px;
        }

        .dash-card {
            height: 90px;
        }

        .dash-container {
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="">
        <nav class="abs-side-navbar abs-toggle navbar-slideout" id="sidenav">
            <div class="abs-navs text-white" style="text-align: center;">
                <img src="./assets/images/logo.jpeg" class="brand-logo" alt="logo" />
            </div>
            <ul class="abs-sidenav-menu">
                <!-- <span class="divider"></span> -->
                <a href="<?php echo $appUrl . '/admindashboard'; ?>" class="abs-menu-item active">
                    <span class="fa fa-clone icon"></span>
                    <span class="text">Dashboard</span>
                </a>
                <a href="<?php echo $appUrl . '/customers'; ?>" class="abs-menu-item">
                    <span class="fa fa-users icon"></span>
                    <span class="text">Customers</span>
                </a>
                <a href="<?php echo $appUrl . '/cards'; ?>" class="abs-menu-item">
                    <span class="fa fa-credit-card icon"></span>
                    <span class="text">Cards</span>
                </a>
                <a href="<?php echo $appUrl . '/reports'; ?>" class="abs-menu-item">
                    <span class="fa fa-bar-chart icon"></span>
                    <span class="text">Reports</span>
                </a>
            </ul>
        </nav>
        <div class="main main-slideout" id="main">
            <nav class="abs-navbar top-bar border-bottom flex-wrap justify-content-between">
                <div class="abs-navs abs-nav-toggle">
                    <button type="button" class="abs-nav-toggler border-0 text-white abs-btn btn-md" style="background: #000;" id="nav-toggler">
                        <i class="fa fa-bars fa-1x"></i>
                    </button>
                </div>
                <div class="abs-navs abs-ord-sm-1">
                    <div class="dropdown">
                        <button type="button" id="my-dropdown" class="abs-btn icon-btn bg-color-light btn-md btn-rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon">
                                <img src="./assets/images/user-avatar.jpg" class="rounded-circle" />
                            </span>
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <!-- <button  class="abs-btn btn-md rounded" >
                            <i class="fa fa-user"></i>
                            Profile
                        </button> -->
                        <div class="dropdown-menu dropdown-menu-right " aria-labelledby="my-dropdown">
                            <a class="dropdown-item " href="<?php echo $appUrl . '/logout'; ?>">
                                <span class="fa fa-power-off text-danger"></span>
                                <span class="ml-2">Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            <?php echo isset($content) ? $content : ''; ?>

        </div>
    </div>
    <script type="text/javascript" src="../assets/js/index.js"></script>
</body>

</html>