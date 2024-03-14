<?php
$errors = isset($_SESSION['report_card_issue_errors']) ? $_SESSION['report_card_issue_errors'] : [];
unset($_SESSION['report_card_issue_errors']);
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

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <title>Dashboard</title>
</head>

<body>

    <header>
        <div class="p-2 d-flex bg-light">
            <img src="assets/images/logo.jpeg" width="50" height="50" />
        </div>
    </header>
    <main>
        <div class="container">
            <dv class="card col-md-9 my-5 mx-auto" style="background-color: rgb(248, 248, 225);">
                <div class="card-body">
                    <?php if (!empty($errors)) : ?>
                        <div class="text-red-500 bg-red-100 p-3 mb-4 border border-red-400 rounded">
                            <?php foreach ($errors as $error) : ?>
                                <p><?php echo $error; ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-center">Payment checkout</h3>
                    <form method="post" action="/card-fraud-detection/checkout">
                        <h6>Billing details</h6>
                        <section>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" required />
                            </div>
                        </section>

                        <h6>Card details</h6>
                        <section class="row">
                            <div class="form-group col-md-6">
                                <label for="cardNumber">Card number</label>
                                <input type="number" class="form-control" name="card_number" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="expiryDate">Expiry date</label>
                                <input type="text" class="form-control" name="expiry_date" required />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cvv">CVV</label>
                                <input type="number" class="form-control" name="cvv" required />
                            </div>
                        </section>
                        <button type="submit" class="btn btn-secondary">
                            Checkout
                        </button>
                    </form>

                    <div class="text-center">
                        <a class="nav-link" data-toggle="modal" data-target="#report" href="">Report issue/fraudulent act</a>
                    </div>
                </div>
            </dv>
        </div>
    </main>

    <div class="modal fade" id="report">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="text-center">Report card issue</h5>
                    <form action="/card-fraud-detection/report-card-issue" method="post">
                        <div class="form-group">
                            <label>Card first 6digits</label>
                            <input type="number" class="form-control" name="first_six_digits" required />
                        </div>
                        <div class="form-group">
                            <label>Card last 4digits</label>
                            <input type="number" class="form-control" name="last_four_digits" required />
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['checkout_success']) && $_SESSION['checkout_success']) {
        echo '<script type="text/javascript">
            $(document).ready(function(){
                $("#successModal").modal("show");
            });
          </script>';
        // Reset the session variable
        $_SESSION['checkout_success'] = false;
    }
    ?>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Checkout Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Your order has been successfully processed.</p>
                </div>
            </div>
        </div>
    </div>


</body>

</html>