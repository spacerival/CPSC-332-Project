<?php
// Diagnostic Test
// Use this to see if MySQLi can be accessed and if you can connect to database

echo "PHP Version: " . phpversion() . "<br>";
echo "Checking mysqli...<br>";

if (extension_loaded('mysqli')) {
    echo "✓ mysqli extension is loaded!<br>";
} else {
    echo "✗ mysqli extension is NOT loaded!<br>";
    die("Please enable mysqli in php.ini");
}


echo "Attempting database connection...<br>";
include 'db_connect.php';

if ($conn) {
    echo "✓ Database connection successful!";
} else {
    echo "✗ Connection failed!";
}

$conn->close();
?>