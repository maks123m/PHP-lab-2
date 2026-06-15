<?php
$host = 'localhost';
$dbname = 'parking_db';
$username = 'root';
$password = '';


try {
    $conn = new PDO("mysql:host=$host; dbname=$dbname;", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo "Подключение проваленно: " . $e->getMessage();
}
?>