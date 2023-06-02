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

if (isset($_POST['user_submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $row = mysqli_fetch_assoc($select_user);
        $_SESSION['user_id'] = $row['user_id'];
        header('location:../user_site/home.php');
    } else {
        $user_message[] = 'Incorrect email or password!';
    }

}

if (isset($_POST['restaurant_submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_restaurant = mysqli_query($conn, "SELECT * FROM `restaurants` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_restaurant) > 0) {
        $row = mysqli_fetch_assoc($select_restaurant);
        $_SESSION['restaurant_id'] = $row['restaurant_id'];
        header('location:../restaurant_site/restaurant_panel.php');
    } else {
        $restaurant_message[] = 'Incorrect email or password!';
    }

}

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Login</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/empty_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Login Form (Start) -->
    <section class="login">

        <h1 class="text_align_center">Login As:</h1>

        <?php
        if (isset($user_message)) {
            foreach ($user_message as $user_message) {
                echo '<div class="message">' . $user_message . '</div>';
            }
        }
        if (isset($restaurant_message)) {
            foreach ($restaurant_message as $restaurant_message) {
                echo '<div class="message">' . $restaurant_message . '</div>';
            }
        }
        ?>

        <div class="tab">
            <button class="tablinks button" onclick="openUserType(event, 'User')">User</button>
            <button class="tablinks button" onclick="openUserType(event, 'Restaurant')">Restaurant</button>
        </div>

        <div id="User" class="tabcontent">
            <div class="login_container text_align_center">
                <h1 class="text_align_center">User</h1>

                <form action="" method="post" enctype="multipart/form-data" class="text_align_center">
                    <input type="email" name="email" placeholder="Enter Email" class="box" required>
                    <input type="password" name="password" placeholder="Enter Password" class="box" required>
                    <input type="submit" name="user_submit" value="Login" class="button login_button">
                    <p>Don't have an account? <a href="register.php">Regiser Now</a></p>
                </form>
                <div class="clear"></div>
            </div>
        </div>

        <div id="Restaurant" class="tabcontent">
            <div class="login_container text_align_center">
                <h1 class="text_align_center">Restaurant</h1>

                <form action="" method="post" enctype="multipart/form-data" class="text_align_center">
                    <input type="email" name="email" placeholder="Enter Email" class="box" required>
                    <input type="password" name="password" placeholder="Enter Password" class="box" required>
                    <input type="submit" name="restaurant_submit" value="Login" class="button login_button">
                    <p>Don't have an account? <a href="register.php">Regiser Now</a></p>
                </form>
                <div class="clear"></div>
            </div>
        </div>

        <script>
            function openUserType(evt, userType) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(userType).style.display = "block";
                evt.currentTarget.className += " active";
            }
        </script>

        <div class="clear"></div>
    </section>
    <!-- Login Form (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>