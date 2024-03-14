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

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/abs-design.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/media-query.css" />
    <title>Admin-login</title>
    <style>
        .bn-img {
            width: 100%;
            max-height: 400px;
        }

        .bg-color {
            background: #23173d;
        }

        .bg-color2 {
            background: #311f57;
            color: #fff;
        }

        .bg-1 {
            background-image: url('./assets/images/broker-img21.jpg');
            background-size: cover;
        }

        .text-color {
            color: #23173d;
        }

        .nav-item .nav-link {
            color: #fff !important;
        }

        .banner {
            background-image: url('assets/images/broker-img1.jpg');
            background-position: fixed;
            background-size: cover;
            height: 430px;
        }

        .banner-block {
            padding-top: 3.5em;
            padding-bottom: 3.5em;
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            height: inherit;
        }

        .bn-2 {
            background: rgba(0, 0, 0, 0.5);
        }

        .banner-text {
            line-height: 1.5em;
            font-size: 18px;
        }

        .ic-img {
            width: 100px;
            height: 100px;
        }

        .list-group.bgl .list-group-item {
            background: #23173d;
            color: white;
            border: 1px solid #aaa;
        }
    </style>
</head>

<body>

    <main class="">
        <div class="col-sm-7 mt-3 mb-3 col-md-5 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 style="color:black" class="text-center">Admin login</h4>
                </div>
                <div class="card-body">
                    <h5 style="color:black" class="font-weight-bold mb-3">Login</h5>
                    <form class="" action="/card-fraud-detection/admin-login/authenticate" method="post">
                        <!-- Display errors if any -->
                        <?php
                        $errors = isset($_SESSION['login_errors']) ? $_SESSION['login_errors'] : [];
                        unset($_SESSION['login_errors']);
                        ?>
                        <?php if (!empty($errors)) : ?>
                            <div class="text-red-500 bg-red-100 p-3 mb-4 border border-red-400 rounded">
                                <?php foreach ($errors as $error) : ?>
                                    <p><?php echo $error; ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Email" required />
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-dark border text-white" value="Login" />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>

</body>

</html>