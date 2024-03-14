<?php
$title = 'customers';
ob_start();
$errors = isset($_SESSION['customer_errors']) ? $_SESSION['customer_errors'] : [];
unset($_SESSION['customer_errors']);
?>


<div class="dash-container">

    <!-- Booking Modal -->
    <div class="modal text-dark" id="newDepositModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title font-weight-bold">Create customer</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form class="" method="post" action="/card-fraud-detection/submit-customer">
                        <div class="form-group mb-2">
                            <label class="mb-1">First name</label>
                            <div class="w-100">
                                <input type="text" min="1" class="abs-form-input" name="first_name" required />
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="mb-1">Last name</label>
                            <div class="w-100">
                                <input type="text" min="1" class="abs-form-input" name="last_name" required />
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="mb-1">Email</label>
                            <div class="w-100">
                                <input type="text" min="1" class="abs-form-input" name="email" required />
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="mb-1">Phone number</label>
                            <div class="w-100">
                                <input type="text" min="1" class="abs-form-input" name="phone" required />
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="mb-1">Address</label>
                            <div class="w-100">
                                <input type="text" min="1" class="abs-form-input" name="address" required />
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="mb-1">Country</label>
                            <div class="w-100">
                                <select class="form-control" id="country" name="country" onchange="loadStates()" required>
                                    <option selected>Select Country</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="United States">United States</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <!-- Add more countries as needed -->
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label class="mb-1">State</label>
                            <div class="w-100">
                                <select class="form-control" id="state" name="state" required>
                                    <!-- The first option will be an empty one -->
                                    <option value=""></option>
                                    <!-- States will be dynamically populated using JavaScript -->
                                </select>
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
        <h4 class="font-weight-bold mt-4 mb-1 text-white">Customers</h4>
    </div>
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <div class="mb-3 text-right">
        <button type="button" data-toggle="modal" data-target="#newDepositModal" class="abs-btn rounded-1 bg-color-light text-white">
            <i class="fa fa-credit-card"></i> New Customer
        </button>
    </div>
    <!-- Inside customers.php -->

    <div class="abs-table-wrapper">
        <?php if (empty($customers)) : ?>
            <p>No customers available.</p>
        <?php else : ?>
            <table class="table table-striped text-white">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer) : ?>
                        <tr>
                            <td><?php echo $customer['FirstName'] . ' ' . $customer['LastName']; ?></td>
                            <td><?php echo $customer['Email']; ?></td>
                            <td><?php echo $customer['Phone']; ?></td>
                            <td><?php echo $customer['Country']; ?></td>
                            <td>
                                <span class="badge badge-<?php echo ($customer['Status'] == 1) ? 'success' : 'danger'; ?>">
                                    <?php echo ($customer['Status'] == 1) ? 'active' : 'inactive'; ?>
                                </span>
                            </td>
                            <td>
                                <form action="/card-fraud-detection/delete-customer" method="post" onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                    <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">
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



<script>
    function loadStates() {
        // Get the selected country
        var selectedCountry = document.getElementById("country").value;

        // Get the state dropdown
        var stateDropdown = document.getElementById("state");

        // Clear existing options
        stateDropdown.innerHTML = '<option value=""></option>';

        // Add states based on the selected country
        switch (selectedCountry) {
            case "Nigeria":
                addStates([
                    "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno",
                    "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "Gombe", "Imo",
                    "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nasarawa",
                    "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba", "Yobe", "Zamfara"
                ]);
                break;
            case "United States":
                addStates(["New York", "California", "Texas"]); // Add states for the United States
                break;
            case "United Kingdom":
                addStates(["London", "Manchester", "Birmingham"]); // Add states for the United Kingdom
                break;
                // Add cases for more countries
        }
    }

    function addStates(states) {
        var stateDropdown = document.getElementById("state");

        // Add each state to the dropdown
        states.forEach(function(state) {
            var option = document.createElement("option");
            option.value = state;
            option.text = state;
            stateDropdown.add(option);
        });
    }
</script>




<?php $content = ob_get_clean();

require_once BASE_PATH . '/views/layouts/admin.php';
?>