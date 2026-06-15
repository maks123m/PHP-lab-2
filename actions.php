<?php
require 'config.php';

if (isset($_POST['add_car'])) {
    $stmt = $conn->prepare("INSERT INTO cars (brand, owner_name, owner_phone, license_plate, entry_date, entry_time, hourly_rate, debt) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['brand'],
        $_POST['owner_name'],
        $_POST['owner_phone'],
        $_POST['license_plate'],
        $_POST['entry_date'],
        $_POST['entry_time'],
        $_POST['hourly_rate'],
        $_POST['debt']
    ]);
    header("Location: index.php");
    exit();
}

if (isset($_GET['exit'])) {
    $car_id = $_GET['exit'];
    
    $stmt = $conn->prepare("SELECT debt FROM cars WHERE id = ?");
    $stmt->execute([$car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($car && $car['debt'] > 0) {
        exit();
    }

    $stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
    $stmt->execute([$car_id]);
    header("Location: index.php");
    exit();
}

if (isset($_POST['update_debt'])) {
    $stmt = $conn->prepare("UPDATE cars SET debt = ? WHERE id = ?");
    $stmt->execute([$_POST['debt'], $_POST['car_id']]);
    header("Location: index.php");
    exit();
}

header("Location: index.php");
exit();
?>