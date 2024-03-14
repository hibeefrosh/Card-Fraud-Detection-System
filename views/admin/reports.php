<?php
$title = 'reports';
ob_start();
?>



<div class="dash-container">
    <div class="mb-2 d-flex justify-content-between align-items-center">
        <h4 class="font-weight-bold mt-4 mb-1 text-white">Reports</h4>
    </div>


    <div class="abs-table-wrapper">
        <?php if (empty($reports)) : ?>
            <p>No reports available.</p>
        <?php else : ?>
            <table class="table table-striped text-white">
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Card Number</th>
                        <th>Cardholder Name</th>
                        <th>Expiry Date</th>
                        <th>Last Used</th>
                        <th>Card Status</th>
                        <th>Message</th>
                        <th>Report Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <td><?php echo $report['report_id']; ?></td>
                            <td><?php echo $report['CardNumber']; ?></td>
                            <td><?php echo $report['CardName']; ?></td>
                            <td><?php echo $report['ExpiryDate']; ?></td>
                            <td><?php echo $report['LastUsed']; ?></td>
                            <td>
                                <span class="badge badge-<?php echo ($report['card_status'] == 1) ? 'success' : 'danger'; ?>">
                                    <?php echo ($report['card_status'] == 1) ? 'Active' : 'Inactive'; ?>
                                </span>
                            </td>
                            <td><?php echo $report['message']; ?></td>
                            <td><?php echo date('F j, Y, g:i a', strtotime($report['report_created_at'])); ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>


</div>

<?php $content = ob_get_clean();

require_once BASE_PATH . '/views/layouts/admin.php';
?>