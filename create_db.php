<?php
$con = mysqli_connect('127.0.0.1', 'root', '');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "CREATE DATABASE IF NOT EXISTS forum_discussion";
if (mysqli_query($con, $sql)) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . mysqli_error($con) . "\n";
}
mysqli_close($con);
