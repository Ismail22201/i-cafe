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

if (isset($_POST['update_profile'])) {

    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    mysqli_query($conn, "UPDATE `restaurants` SET restaurant_name = '$update_name'  WHERE restaurant_id = '$restaurant_id'") or die('query failed');

    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if ($update_pass != $old_pass) {
            $message[] = 'Old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'Confirm password not matched!';
        } else {
            mysqli_query($conn, "UPDATE `restaurants` SET password = '$confirm_pass' WHERE restaurant_id = '$restaurant_id'") or die('query failed');
            $message[] = 'Password updated successfully!';
        }
    }

    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = '../assets/profile_pictures/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image is too large!';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `restaurants` SET image = '$update_image' WHERE restaurant_id = '$restaurant_id'") or die('query failed');
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'Image updated succssfully!';
        }
    }

}

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Profile</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/restaurant_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Edit Profile (Start) -->
    <section>
        <div class="edit_profile text_align_center">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM `restaurants` WHERE restaurant_id = '$restaurant_id'") or die('query failed');
            if (mysqli_num_rows($select) > 0) {
                $fetch = mysqli_fetch_assoc($select);
            }
            ?>

            <form action="" method="post" enctype="multipart/form-data">
                <?php
                if ($fetch['image'] == '') {
                    echo '<img src="../assets/profile_pictures/default-avatar.png">';
                } else {
                    echo '<img src="../assets/profile_pictures/' . $fetch['image'] . '">';
                }
                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<div class="message">' . $message . '</div>';
                    }
                }
                ?>
                <p>Restaurant Name: </p>
                <input type="text" name="update_name" value="<?php echo $fetch['restaurant_name']; ?>" class="box">
                <p>Email: </p>
                <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                <p>Profile Picture: </p>
                <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                <p>Old Password: </p>
                <input type="password" name="update_pass" placeholder="Enter Previous Password" class="box">
                <p>New Password: </p>
                <input type="password" name="new_pass" placeholder="Enter New Password" class="box">
                <p>Confirm Password: </p>
                <input type="password" name="confirm_pass" placeholder="Confirm New Password" class="box">
                <input type="submit" value="Save" name="update_profile" class="button update_button">
            </form>

        </div>
    </section>
    <!-- Edit Profile (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>