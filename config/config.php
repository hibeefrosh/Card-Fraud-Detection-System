<?php

return [
    'app' => [
        'name' => ' card-fraud-detection',
        'url' => 'http://localhost/card-fraud-detection',
    ],
    'database' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'dbname' => 'card-fraud-detection',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Add other database options if needed
        ],
    ],
    // Add more configuration settings as needed
];
