<!-- 
    Final Year Project
    
    Title: Smart Campus Food Ordering System with Emotion Booster

    Supervisor: Asst. Prof. Dr. Akeem Olowolayemo
    
    Done by:
        Ahmed Faisal 1921967
        Muhammad Ismail 1922235
-->
<?php

include '../components/connect.php';
session_start();
$restaurant_id = $_SESSION['restaurant_id'];

if (!isset($restaurant_id)) {
    header('location:../all_users/login.php');
}

if (isset($_GET['logout'])) {
    unset($restaurant_id);
    session_destroy();
    header('location:../all_users/login.php');
}

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Panel</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/restaurant_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>