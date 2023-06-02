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

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_SESSION['restaurant_id'])) {
    $restaurant_id = $_SESSION['restaurant_id'];
} else {
    $restaurant_id = '';
}

if (isset($_POST['user_submit'])) {

    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../assets/profile_pictures/' . $image;

    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $user_message[] = 'User already exist!';
    } else {
        if ($pass != $cpass) {
            $user_message[] = 'Confirm password not matched!';
        } elseif ($image_size > 2000000) {
            $user_message[] = 'Image size is too large!';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO `users`(user_name, email, password, image) VALUES('$user_name', '$email', '$pass', '$image')") or die('query failed');

            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $user_message[] = 'Registered successfully!';
                header('location:login.php');
            } else {
                $user_message[] = 'Registeration failed!';
            }
        }
    }

}

if (isset($_POST['restaurant_submit'])) {

    $restaurant_name = mysqli_real_escape_string($conn, $_POST['restaurant_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../assets/profile_pictures/' . $image;

    $select = mysqli_query($conn, "SELECT * FROM `restaurants` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $restaurant_message[] = 'Restaurant already exist!';
    } else {
        if ($pass != $cpass) {
            $restaurant_message[] = 'Confirm password not matched!';
        } elseif ($image_size > 2000000) {
            $restaurant_message[] = 'Image size is too large!';
        } else {
            $insert = mysqli_query($conn, "INSERT INTO `restaurants`(restaurant_name, email, password, image) VALUES('$restaurant_name', '$email', '$pass', '$image')") or die('query failed');

            if ($insert) {
                move_uploaded_file($image_tmp_name, $image_folder);
                $restaurant_message[] = 'Registered successfully!';
                header('location:login.php');
            } else {
                $restaurant_message[] = 'Registeration failed!';
            }
        }
    }

}

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Register</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/empty_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Login Form (Start) -->
    <section class="login">

        <h1 class="text_align_center">Register As:</h1>

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
                    <input type="text" name="user_name" placeholder="Enter Username" class="box" required>
                    <input type="email" name="email" placeholder="Enter Email" class="box" required>
                    <input type="password" name="password" placeholder="Enter Password" class="box" required>
                    <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required>
                    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                    <input type="submit" name="user_submit" value="Register" class="button login_button">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </form>

                <div class="clear"></div>
            </div>
        </div>

        <div id="Restaurant" class="tabcontent">
            <div class="login_container text_align_center">
                <h1 class="text_align_center">Restaurant</h1>
                <form action="" method="post" enctype="multipart/form-data" class="text_align_center">
                    <input type="text" name="restaurant_name" placeholder="Enter Restaurant Name" class="box" required>
                    <input type="email" name="email" placeholder="Enter Email" class="box" required>
                    <input type="password" name="password" placeholder="Enter Password" class="box" required>
                    <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required>
                    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                    <input type="submit" name="restaurant_submit" value="Register" class="button login_button">
                    <p>Already have an account? <a href="login.php">Login</a></p>
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