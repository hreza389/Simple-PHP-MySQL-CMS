<?php
ob_start();

// crete an array
$db = array(
    'db_host' => 'localhost',
    'db_username' => 'root',
    'db_password' => '',
    'db_name' => 'cms'
);

// convert db to constant via loop
foreach ($db as $key => $value) {
    define(strtoupper($key), $value); // constants are uppercase
}

// connect to db
$connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

$query = "SET NAMES utf8";
mysqli_query($connection, $query);

// check connection
if(!$connection) {
    die("Database connection failed");
}

