<?php

class AdminController
{
    private $pdo;

    public function __construct()
    {
        $config = require BASE_PATH . '/config/config.php';
        $dbConfig = $config['database'];

        try {
            $this->pdo = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
                $dbConfig['username'],
                $dbConfig['password']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function index()
    {
       
        include BASE_PATH . '/views/admin/index.php';
    }

    public function login()
    {
        // Display the login form
        include BASE_PATH . '/views/admin/login.php';
    }

    public function authenticate()
    {
 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'];
            $password = $_POST['password'];



            $errors = [];

            if (empty($email) || empty($password)) {
                $errors[] = 'Email and password are required.';
            }

            if (empty($errors)) {
                $stmt = $this->pdo->prepare("SELECT id, password FROM admin WHERE email = ?");
                $stmt->execute([$email]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                echo $admin;

                if ($admin && password_verify($password, $admin['password'])) {

                    $_SESSION['admin'] = $admin;

                    header("Location: /card-fraud-detection/admindashboard");
                    exit;
                } else {
                    $errors[] = 'Invalid email or password.';
                }
            }

            $_SESSION['login_errors'] = $errors;

            // Redirect back to the login page with errors
            header("Location: /card-fraud-detection/admin-login");
            exit;
        }
    }

    private function getTotalCustomers()
    {
        // Implement logic to query the database for total customers
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM customers');
        return $stmt->fetchColumn();
    }

    private function getTotalCardIssued()
    {
        // Implement logic to query the database for total card issued
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM cards');
        return $stmt->fetchColumn();
    }

    private function getCustomers()
    {
        // Implement logic to query the database for all customers
        $stmt = $this->pdo->query('SELECT * FROM customers');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCards()
    {
        // Implement logic to query the database for all customers
        $stmt = $this->pdo->query('SELECT * FROM cards');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function dashboard()
    {

        // Retrieve data for the dashboard
        $totalCustomers = $this->getTotalCustomers();
        $totalCardIssued = $this->getTotalCardIssued();

        include BASE_PATH . '/views/admin/dashboard.php';
    }

    public function customers()
    {
     
        // Retrieve all customers from the database
        $customers = $this->getCustomers();

        include BASE_PATH . '/views/admin/customers.php';
        
    }

    public function cards()
    {

        // Retrieve all customers from the database
        $customers = $this->getCustomers();
        $cards = $this->getCards();
        

        include BASE_PATH . '/views/admin/cards.php';
    }

    public function reports()
    {
        try {
            // Fetch reports with related card details
            $stmt = $this->pdo->prepare("
            SELECT
                r.id as report_id,
                r.card_id,
                r.message,
                r.created_at as report_created_at,
                c.id as card_id,
                c.CardNumber,
                c.CardName,
                c.ExpiryDate,
                c.LastUsed,
                c.Status as card_status,
                c.DateIssued,
                c.initial_deposit
            FROM
                reports r
            LEFT JOIN
                cards c ON r.card_id = c.id
        ");
            $stmt->execute();
            $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the exception (log, redirect, show error, etc.)
            error_log("Error fetching reports: " . $e->getMessage());
            // Optionally redirect or display an error page
            exit;
        }

        // Include the view with the fetched reports
        include BASE_PATH . '/views/admin/reports.php';
    }


    public function submitCustomer()
    {
        // Check if the form is submitted using POST method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $country = $_POST['country'];
            $state = $_POST['state'];

            // Validate form data (you can add more validation as needed)
            $errors = [];

            if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($address) || empty($country) || empty($state)) {
                $errors[] = 'All fields are required.';
            }

            // Add additional validation rules as needed

            if (empty($errors)) {
                try {
                    // Insert the new customer into the database
                    $stmt = $this->pdo->prepare("INSERT INTO customers (firstname, lastname, email, phone, address, country, state) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([$firstName, $lastName, $email, $phone, $address, $country, $state]);

                    // Redirect to the customers page or any other page
                    header("Location: /card-fraud-detection/customers");
                    exit;
                } catch (PDOException $e) {
                    // Check if the error is a duplicate entry error
                    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        // Add a user-friendly message to the errors array
                        $_SESSION['customer_errors'][] = 'The provided email address is already in use. Please use a different email address.';
                    } else {
                        // Log the error
                        error_log("Error Message: {$e->getMessage()}\nStack Trace: {$e->getTraceAsString()}", 3, BASE_PATH . '/logs/error.log');

                        // Add a generic error message
                        $_SESSION['customer_errors'][] = 'An error occurred while processing your request. Please try again later.';
                    }

                    // Redirect back to the form page with errors
                    header("Location: /card-fraud-detection/customers");
                    exit;
                }
            } else {
                // Store errors in session for displaying on the form page
                $_SESSION['customer_errors'] = $errors;

                // Redirect back to the form page with errors
                header("Location: /card-fraud-detection/customers");
                exit;
            }
        }
    }




    public function issueCard()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerName = $_POST['customer_id'];
            $initialDeposit = $_POST['initial_deposit'];

           
            $errors = [];

            if (empty($customerName) || empty($initialDeposit)) {
                $errors[] = 'Customer name and initial deposit are required.';
            }


            if (empty($errors)) {
                try {
                    $stmt = $this->pdo->prepare("SELECT id FROM customers WHERE CONCAT(FirstName, ' ', LastName) = ?");
                    $stmt->execute([$customerName]);
                    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($customer) {
                        $customerID = $customer['id'];

                        $accountNumber = mt_rand(100000000000000, 999999999999999);

                        $expiryDate = date('Y-m-d', strtotime('+4 years'));

                        $lastUsed = date('Y-m-d');

                        $status = 1;

                        $stmt = $this->pdo->prepare("INSERT INTO cards (cardnumber, cardname, expirydate, lastused, status, initial_deposit, customer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$accountNumber, $customerName, $expiryDate, $lastUsed, $status, $initialDeposit, $customerID]);


                        header("Location: /card-fraud-detection/cards");
                        exit;
                    } else {
                        // Customer not found, display error message
                        $errors[] = 'Customer not found.';
                    }
                } catch (PDOException $e) {
                  
                    error_log("Error Message: {$e->getMessage()}\nStack Trace: {$e->getTraceAsString()}", 3, BASE_PATH . '/logs/error.log');

                    $errors[] = 'An error occurred while processing the request. Please try again later.';
                }
            }

            $_SESSION['issue_card_errors'] = $errors;

            header("Location: /card-fraud-detection/cards");
            exit;
        }
    }


    public function deleteCustomer()
    {
        // Check if the form is submitted using POST method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve customer ID from the form data
            $customerId = $_POST['customer_id'];

            try {
                // Delete the customer from the database
                $stmt = $this->pdo->prepare("DELETE FROM customers WHERE id = ?");
                $stmt->execute([$customerId]);

                // Redirect back to the customers page or any other page
                header("Location: /card-fraud-detection/customers");
                exit;
            } catch (PDOException $e) {
                // Log the error
                error_log("Error Message: {$e->getMessage()}\nStack Trace: {$e->getTraceAsString()}", 3, BASE_PATH . '/logs/error.log');

                // Add a generic error message
                $_SESSION['delete_customer_error'] = 'An error occurred while deleting the customer. Please try again later.';

                // Redirect back to the customers page with an error message
                header("Location: /card-fraud-detection/customers");
                exit;
            }
        }
    }

    public function deleteCard()
    {
        // Check if the form is submitted using POST method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve card ID from the form data
            $cardId = $_POST['card_id'];

            try {
                // Delete the card from the database
                $stmt = $this->pdo->prepare("DELETE FROM cards WHERE id = ?");
                $stmt->execute([$cardId]);

                // Redirect back to the cards page or any other page
                header("Location: /card-fraud-detection/cards");
                exit;
            } catch (PDOException $e) {
                // Log the error
                error_log("Error Message: {$e->getMessage()}\nStack Trace: {$e->getTraceAsString()}", 3, BASE_PATH . '/logs/error.log');

                // Add a generic error message
                $_SESSION['delete_card_error'] = 'An error occurred while deleting the card. Please try again later.';

                // Redirect back to the cards page with an error message
                header("Location: /card-fraud-detection/cards");
                exit;
            }
        }
    }

    public function fetchCardDetails()
    {
        // Check if the form is submitted using POST method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstSixDigits = $_POST['first_six_digits'];
            $lastFourDigits = $_POST['last_four_digits'];

            // Validate form data (you can add more validation as needed)
            $errors = [];

            if (empty($firstSixDigits) || empty($lastFourDigits)) {
                $errors[] = 'Both first 6 digits and last 4 digits are required.';
            }

            // Add additional validation rules as needed

            if (empty($errors)) {
                try {
                    // Fetch the card owner based on the provided digits
                    $stmt = $this->pdo->prepare("SELECT * FROM cards WHERE SUBSTRING(cardnumber, 1, 6) = ? AND SUBSTRING(cardnumber, -4) = ?");
                    $stmt->execute([$firstSixDigits, $lastFourDigits]);
                    $cardOwner = $stmt->fetch(PDO::FETCH_ASSOC);
                   
                    if ($cardOwner) {
                       
                        $_SESSION['card_owner_details'] = $cardOwner;

                        header("Location: /card-fraud-detection/reports"); 
                        exit;
                    } else {
                        
                        $_SESSION['fetch_card_owner_errors'][] = 'No card owner found.';
                      
                        header("Location: /card-fraud-detection/reports"); 
                        exit;
                    }
                } catch (PDOException $e) {
                    
                    echo "Error fetching card details: " . $e->getMessage();
                }
            } else {
                // Store errors in session for displaying on the form page
                $_SESSION['fetch_card_owner_errors'] = $errors;

                // Redirect back to the form page with errors
                header("Location: /card-fraud-detection/reports"); 
                exit;
            }
        }
    }

    public function reportCardIssue()
    {
        // Check if the form is submitted using POST method
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $firstSixDigits = $_POST['first_six_digits'];
            $lastFourDigits = $_POST['last_four_digits'];
            $message = $_POST['message'];


            $errors = [];

            if (empty($firstSixDigits) || empty($lastFourDigits) || empty($message)) {
                $errors[] = 'All fields are required.';
            }



            if (empty($errors)) {
                try {
                    // Fetch the card based on the provided digits
                    $stmt = $this->pdo->prepare("SELECT * FROM cards WHERE SUBSTRING(CardNumber, 1, 6) = ? AND SUBSTRING(CardNumber, -4) = ?");
                    $stmt->execute([$firstSixDigits, $lastFourDigits]);
                    $card = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($card) {
                        // Card found, insert report into reports table
                        $stmt = $this->pdo->prepare("INSERT INTO reports (card_id, message) VALUES (?, ?)");
                        $stmt->execute([$card['id'], $message]);

                        header("Location: /card-fraud-detection/");
                        exit;
                    } else {
                        // Card not found, display error message
                        $errors[]  = 'Card not found.';
                        $_SESSION['report_card_issue_errors'] = $errors;
                        header("Location: /card-fraud-detection/"); 
                        exit;
                    }
                } catch (PDOException $e) {
                    // Log the error
                    error_log("Error Message: {$e->getMessage()}\nStack Trace: {$e->getTraceAsString()}", 3, BASE_PATH . '/logs/error.log');

                    // Add a generic error message
                    $errors[]  = 'An error occurred while reporting the card issue. Please try again later.';
                    $_SESSION['report_card_issue_errors'] = $errors;
                    header("Location: /card-fraud-detection/");
                    exit;
                }
            } else {
                // Store errors in session for displaying on the form page
                $_SESSION['report_card_issue_errors'] = $errors;

                // Redirect back to the form page with errors
                header("Location: /card-fraud-detection/");
                exit;
            }
        }
    }

    function processPaymentCheckout()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $cardNumber = $_POST['card_number'];
            $expiryDate = $_POST['expiry_date'];
            $cvv = $_POST['cvv'];

            if (empty($name) || empty($email) || empty($address) || empty($cardNumber) || empty($expiryDate) || empty($cvv)) {
                $errors[]  = 'All fields are required. Please fill in all the details.';
                $_SESSION['report_card_issue_errors'] = $errors;
                header("Location: /card-fraud-detection/");
                exit;
            }
            
            $sqlCard = "SELECT * FROM cards WHERE cardnumber = :cardNumber AND expirydate = :expiryDate";
            $stmtCard = $this->pdo->prepare($sqlCard);
            $stmtCard->bindParam(':cardNumber', $cardNumber);
            $stmtCard->bindParam(':expiryDate', $expiryDate);
            $stmtCard->execute();

            if ($stmtCard->rowCount() > 0) {
                // Card details are valid, proceed with the payment checkout

                // Insert data into the 'payment_checkout' table
                $sqlPayment = "INSERT INTO payment_checkout (name, email, address, card_number, expiry_date, cvv) 
                           VALUES (:name, :email, :address, :cardNumber, :expiryDate, :cvv)";

                $stmtPayment = $this->pdo->prepare($sqlPayment);
                $stmtPayment->bindParam(':name', $name);
                $stmtPayment->bindParam(':email', $email);
                $stmtPayment->bindParam(':address', $address);
                $stmtPayment->bindParam(':cardNumber', $cardNumber);
                $stmtPayment->bindParam(':expiryDate', $expiryDate);
                $stmtPayment->bindParam(':cvv', $cvv);

                if ($stmtPayment->execute()) {
                    $_SESSION['checkout_success'] = true;
                    header("Location: /card-fraud-detection/");
                    exit;
                } else {
                    // Card not found, display error message
                    $errors[]  = 'Error inserting data into the database.';
                    $_SESSION['report_card_issue_errors'] = $errors;
                    header("Location: /card-fraud-detection/");
                    exit;
                }
            } else {
                // Invalid card details
                $errors[]  = 'Invalid card details. Please check and try again.';
                $_SESSION['report_card_issue_errors'] = $errors;
                header("Location: /card-fraud-detection/");
                exit;
            }
        }
    }




    public function logout()
    {
        // Start the session
        session_start();

        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page or any other page
        header("Location: /card-fraud-detection/admin-login");
        exit;
    }
}
