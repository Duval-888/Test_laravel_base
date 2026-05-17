<?php
$con = mysqli_connect('127.0.0.1', 'root', '', 'forum_discussion');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "DROP TABLE IF EXISTS migrations; DROP TABLE IF EXISTS users;";
if (mysqli_multi_query($con, $sql)) {
    echo "Tables dropped successfully\n";
} else {
    echo "Error: " . mysqli_error($con) . "\n";
}
mysqli_close($con);
