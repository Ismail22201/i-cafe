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
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $address_line3 = $_POST['address_line3'];

    $card_type = $_POST['card_type'];
    $name_on_card = $_POST['name_on_card'];
    $card_no = $_POST['card_no'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $security_code = $_POST['security_code'];

    mysqli_query($conn, "UPDATE `users` SET user_name = '$update_name', email = '$update_email' WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET address_line1 = '$address_line1'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET address_line2 = '$address_line2'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET address_line3 = '$address_line3'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET card_type = '$card_type'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET name_on_card = '$name_on_card'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET card_no = '$card_no'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET month = '$month'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET year = '$year'  WHERE user_id = '$user_id'") or die('query failed');

    mysqli_query($conn, "UPDATE `users` SET security_code = '$security_code'  WHERE user_id = '$user_id'") or die('query failed');
    
    /*
    $update_address1 = $conn->prepare("UPDATE `users` SET address_line1 = ? WHERE user_id = ?");
    $update_address1->execute([$address_line1, $user_id]);

    $update_address2 = $conn->prepare("UPDATE `users` SET address_line2 = ? WHERE user_id = ?");
    $update_address2->execute([$address_line2, $user_id]);

    $update_address3 = $conn->prepare("UPDATE `users` SET address_line3 = ? WHERE user_id = ?");
    $update_address3->execute([$address_line3, $user_id]);

    $update_cardtype = $conn->prepare("UPDATE `users` SET card_type = ? WHERE user_id = ?");
    $update_cardtype->execute([$card_type, $user_id]);

    $update_name_on_card = $conn->prepare("UPDATE `users` SET name_on_card = ? WHERE user_id = ?");
    $update_name_on_card->execute([$name_on_card, $user_id]);

    $update_card_no = $conn->prepare("UPDATE `users` SET card_no = ? WHERE user_id = ?");
    $update_card_no->execute([$card_no, $user_id]);

    $update_month = $conn->prepare("UPDATE `users` SET month = ? WHERE user_id = ?");
    $update_month->execute([$month, $user_id]);

    $update_year = $conn->prepare("UPDATE `users` SET year = ? WHERE user_id = ?");
    $update_year->execute([$year, $user_id]);

    $update_security_code = $conn->prepare("UPDATE `users` SET security_code = ? WHERE user_id = ?");
    $update_security_code->execute([$security_code, $user_id]);
    
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
            mysqli_query($conn, "UPDATE `users` SET password = '$confirm_pass' WHERE user_id = '$user_id'") or die('query failed');
            $message[] = 'Password updated successfully!';
        }
    }
    */

    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = '../assets/profile_pictures/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'Image is too large!';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `users` SET image = '$update_image' WHERE user_id = '$user_id'") or die('query failed');
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
    <?php include '../components/user_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Edit Profile (Start) -->
    <section>
        <div class="edit_profile text_align_center">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'") or die('query failed');
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
                <p>Username: </p>
                <input type="text" name="update_name" value="<?php echo $fetch['user_name']; ?>" class="box">
                <p>Email: </p>
                <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                <p>Profile Picture: </p>
                <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                <?php
                $user_info = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'") or die('query failed');
                while ($fetch_info = mysqli_fetch_assoc($user_info)) {
                ?>
                <p>Budget (RM): </p>
                <input type="number" name="card_no" placeholder="Budget" class="box budget_disabled" value="<?= $fetch_info['budget']; ?>" required>

                <p>Address: </p>
                <input type="text" name="address_line1" placeholder="Address Line 1" class="box" maxlength="50" value="<?= $fetch_info['address_line1']; ?>" required>
                <input type="text" name="address_line2" placeholder="Address Line 2" class="box" maxlength="50" value="<?= $fetch_info['address_line2']; ?>">
                <input type="text" name="address_line3" placeholder="Address Line 3" class="box" maxlength="50" value="<?= $fetch_info['address_line3']; ?>">

                
                <p>Card Info: </p>
                
                
                <input type="radio" name="card_type" class="bullet" value="VISA" <?= ($fetch_info['card_type'] == 'VISA') ? 'checked' : ''; ?>>
                <img style="margin-right: 13px" class="card_logo" src="../assets/VisaLogo.png" alt="VISA Logo">
                
                <input style="margin-left: 13px" type="radio" name="card_type" value="MasterCard" <?= ($fetch_info['card_type'] == 'MasterCard') ? 'checked' : ''; ?>>
                <img class="card_logo" src="../assets/MasterCardLogo.png" alt="MasterCard Logo"><br>
                
                <input type="text" name="name_on_card" placeholder="Enter Name On Card" class="box" value="<?= $fetch_info['name_on_card']; ?>" required>
                <input type="number" name="card_no" placeholder="Enter Card Number" class="box" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength = "16" value="<?= $fetch_info['card_no']; ?>" required>
                
                <select name="month" required>
                    <option value="<?= ($fetch_info['month'] == '') ? 'Month' : $fetch_info['month']; ?>" selected><?= ($fetch_info['month'] == '') ? 'Month' : $fetch_info['month']; ?></option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>

                <select name="year" required>
                    <option value="<?= ($fetch_info['year'] == '') ? 'Year' : $fetch_info['year']; ?>" selected><?= ($fetch_info['year'] == '') ? 'Year' : $fetch_info['year']; ?></option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                </select>

                <input type="number" name="security_code" placeholder="Security Code" class="box" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength = "3" value="<?= $fetch_info['security_code']; ?>" required>
                <?php
                }
                ?>

                <!--
                <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                <p>Old Password: </p>
                <input type="password" name="update_pass" placeholder="Enter Previous Password" class="box">
                <p>New Password: </p>
                <input type="password" name="new_pass" placeholder="Enter New Password" class="box">
                <p>Confirm Password: </p>
                <input type="password" name="confirm_pass" placeholder="Confirm New Password" class="box">
                -->
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