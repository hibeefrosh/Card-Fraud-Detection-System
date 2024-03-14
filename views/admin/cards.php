<?php
$title = 'cards';
ob_start();
if (isset($_SESSION['appName']) && isset($_SESSION['appUrl'])) {
    $appName = $_SESSION['appName'];
    $appUrl = $_SESSION['appUrl'];
}
$errors = isset($_SESSION['issue_card_errors']) ? $_SESSION['issue_card_errors'] : [];
unset($_SESSION['issue_card_errors']);
?>


<div class="dash-container">
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Booking Modal -->
    <div class="modal text-dark" id="newDepositModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">Issue new Card</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="/card-fraud-detection/issue-card">
                        <div class="form-group mb-2">
                            <label class="mb-1">Customer</label>
                            <div class="w-100">
                                <select class="abs-form-input" name="customer_id">
                                    <option value="">Select Customer</option>
                                    <?php foreach ($customers as $customer) : ?>
                                        <option value="<?php echo $customer['FirstName'] . ' ' . $customer['LastName']; ?>"><?php echo $customer['FirstName'] . ' ' . $customer['LastName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="mb-1">Initial deposit (&#8358;)</label>
                            <div class="w-100">
                                <input type="number" min="1" class="abs-form-input" name="initial_deposit" value="" />
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <button class="btn bg-color" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <!-- END MODAL -->

    <div class="mb-2 d-flex justify-content-between align-items-center">
        <h4 class="font-weight-bold mt-4 mb-1 text-white">Cards</h4>
    </div>
    <div class="mb-3 text-right">
        <button type="button" data-toggle="modal" data-target="#newDepositModal" class="abs-btn rounded-1 bg-color-light text-white">
            <i class="fa fa-credit-card"></i> New Card
        </button>
    </div>
    <div class="abs-table-wrapper">
        <?php if (empty($cards)) : ?>
            <p>No customers cards found.</p>
        <?php else : ?>

            <table class="table table-striped text-white">
                <thead>
                    <th>Card number</th>
                    <th>Card name</th>
                    <th>Expiry date</th>
                    <th>Last used</th>
                    <th>Status</th>
                    <th>Date issued</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach ($cards as $card) : ?>
                        <tr>
                            <td>
                                <?php
                                $cardNumber = $card['CardNumber'];
                                $firstSix = substr($cardNumber, 0, 6);
                                $lastFour = substr($cardNumber, -4);
                                $maskedNumber = $firstSix . str_repeat('*', strlen($cardNumber) - 10) . $lastFour;
                                echo $maskedNumber;
                                ?>
                            </td>

                            <td><?php echo $card['CardName']; ?></td>
                            <td><?php echo $card['ExpiryDate']; ?></td>
                            <td><?php echo date('F j, Y', strtotime($card['LastUsed'])); ?></td>
                            <td>
                                <span class="badge badge-<?php echo ($card['Status'] === 1) ? 'success' : 'danger'; ?>">
                                    <?php echo ($card['Status'] === 1) ? 'active' : 'inactive'; ?>
                                </span>
                            </td>

                            <td><?php echo date('F j, Y', strtotime($card['DateIssued'])); ?></td>
                            <td>
                                <form action="/card-fraud-detection/delete-card" method="post" onsubmit="return confirm('Are you sure you want to delete this card?');">
                                    <input type="hidden" name="card_id" value="<?php echo $card['id']; ?>">
                                    <button type="submit" style=" cursor: pointer;">
                                        <!-- Font Awesome trash icon -->
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>

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