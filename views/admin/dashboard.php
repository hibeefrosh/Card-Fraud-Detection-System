<?php
$title = 'Admin dashboard';
ob_start();
?>




<div class="dash-container">

    <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-bold mt-4 mb-1 text-white">Dashboard</h4>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6 col-md-4 mb-3">
            <div class="abs-card dash-card bg-dark text-white">
                <div class="abs-card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <h6 class="">Total Customers</h6>
                            <h3 class="font-weight-bold"><?php echo $totalCustomers; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-4 mb-3">
            <div class="abs-card dash-card bg-dark text-white">
                <div class="abs-card-body">
                    <div class="d-flex align-items-center">
                        <div class="">
                            <h6 class="">Total Card issued</h6>
                            <h3 class="font-weight-bold"><?php echo $totalCardIssued; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>




<?php $content = ob_get_clean();

require_once BASE_PATH . '/views/layouts/admin.php';
?>