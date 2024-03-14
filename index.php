<?php
$config = require __DIR__ . '/config/config.php';
// Accessing app configuration
$appConfig = $config['app'];
$appName = $appConfig['name'];
$appUrl = $appConfig['url'];

// Store values in the session
session_start();
$_SESSION['appName'] = $appName;
$_SESSION['appUrl'] = $appUrl;


define('BASE_PATH', __DIR__);
$request = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);

//  base path
$basePath = '/card-fraud-detection';

// Routes that require authentication
$authenticatedRoutes = [
    $basePath . '/admindashboard',
    $basePath . '/customers',
    $basePath . '/cards',
    $basePath . '/logout',
    $basePath . '/submit-customer',
    $basePath . '/issue-card',
    $basePath . '/delete-customer',
    $basePath .'/delete-card',
    $basePath . '/reports',

];

// Check if the current route requires authentication
if (in_array($request, $authenticatedRoutes) && !isset($_SESSION['admin'])) {
    // Redirect to the login page or perform any other authentication logic
    header("Location: $basePath/admin-login");
    exit;
}

// Define allowed routes
$allowedRoutes = [
    $basePath . '/',
    $basePath . '/customers',
    $basePath . '/submit-customer',
    $basePath . '/cards',
    $basePath . '/issue-card',
    $basePath . '/admin-login',
    $basePath . '/admin-login/authenticate',
    $basePath . '/admindashboard',
    $basePath . '/delete-customer',
    $basePath . '/logout',
    $basePath . '/reports',
    $basePath . '/report-card-issue',
    $basePath . '/delete-card',
    $basePath . '/checkout',
];

// Validate against the whitelist
if (!in_array($request, $allowedRoutes)) {
    // Log the error
    error_log('404 Not Found - ' . $_SERVER['REQUEST_URI']);

    // Respond with a generic message
    header("HTTP/1.0 404 Not Found");
    echo '404 Not Found';
    exit;
}


// Switch based on the validated request URI
switch ($request) {
    case $basePath . '/':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->index();
        break;
    case $basePath . '/admin-login':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->login();
        break;
    case $basePath . '/admin-login/authenticate':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->authenticate();
        break;
    case $basePath . '/admindashboard':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
    case $basePath . '/customers':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->customers();
        break;
    case $basePath . '/submit-customer':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->submitCustomer();
        break;
    case $basePath . '/cards':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->cards();
        break;
    case $basePath . '/issue-card':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->issueCard();
        break;
    case $basePath . '/logout':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->logout();
        break;
    case $basePath . '/delete-customer':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteCustomer();
        break;
    case $basePath . '/delete-card':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteCard();
        break;
    case $basePath . '/reports':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->reports();
        break;
    case $basePath . '/report-card-issue':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->reportCardIssue();
        break;
    case $basePath . '/checkout':
        require __DIR__ . '/src/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->processPaymentCheckout();
        break;
    default:
        // Log the error
        error_log('404 Not Found - ' . $_SERVER['REQUEST_URI']);

        // Respond with a generic message
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        break;
}
