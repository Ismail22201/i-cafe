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

if (!isset($user_id)) {
    header('location:../all_users/login.php');
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:../all_users/login.php');
}

if (isset($_POST['place_order'])) {

    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

    $address_line1 = $_POST['address_line1'];
    $address_line2 = $_POST['address_line2'];
    $address_line3 = $_POST['address_line3'];

    $card_type = $_POST['card_type'];
    $name_on_card = $_POST['name_on_card'];
    $card_no = $_POST['card_no'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $security_code = $_POST['security_code'];


    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    $user_info = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {

        mysqli_query($conn, "UPDATE `orders` SET status = 'Ordered' WHERE user_id = '$user_id' AND status = 'In Cart'") or die('query failed');

        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

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
        $update_status = $conn->prepare("UPDATE `orders` SET status = ? WHERE status = ?");
        $update_status->execute(['Ordered', 'In Cart']);

        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $delete_cart->execute([$user_id]);

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
        $update_security_code->execute([$security_code, $user_id]);*/



        $message[] = 'Order placed successfully!';

        header('location:../user_site/user_orders.php');
    } else {
        $message[] = 'Your cart is empty!';

    }

}

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Checkout</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/user_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Checkout (Start) -->
    <section class="checkout" style="padding-top: 0;">

        <div class="checkout_container ">
            <h1 class="text_align_center">Checkout</h1>

            <form action="" method="post">
                <?php
                $grand_total = 0;
                $cart_items[] = '';
                $show_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                if (mysqli_num_rows($show_cart) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($show_cart)) {
                        $cart_items[] = $fetch_products['product_name'] . ' (' . $fetch_products['price'] . ' x ' . $fetch_products['quantity'] . ') - ';
                        $total_products = implode($cart_items);
                        $grand_total += ($fetch_products['price'] * $fetch_products['quantity']);
                        ?>

                        <input type="hidden" name="cart_id" value="<?= $fetch_products['cart_id']; ?>">
                        <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
                        <input type="hidden" name="restaurant_id" value="<?= $fetch_products['restaurant_id']; ?>">
                        <input type="hidden" name="restaurant_name" value="<?= $fetch_products['restaurant_name']; ?>">
                        <input type="hidden" name="product_name" value="<?= $fetch_products['product_name']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                        <input type="hidden" name="type" value="<?= $fetch_products['type']; ?>">
                        <input type="hidden" name="quantity" value="<?= $fetch_products['quantity']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">

                        <div>
                            <p><span class="name">
                                    <?= $fetch_products['product_name']; ?>
                                </span><span class="price">RM
                                    <?= $fetch_products['price']; ?> x
                                    <?= $fetch_products['quantity']; ?>
                                </span></p>
                        </div>

                        <?php
                    }
                } else {
                    echo '<p class="empty">Your cart is empty!</p>';
                }
                ?>
                <p class="grand-total"><span class="name text_align_center">Grand Total: </span><span class="price">RM
                        <?= $grand_total; ?>
                    </span></p>
                <?php
                $user_info = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'") or die('query failed');
                while ($fetch_info = mysqli_fetch_assoc($user_info)) {
                ?>
                <div class=" text_align_center">
                <div style="margin: 2.6%;"></div>
                <h1 class="text_align_center">Delivery Address</h1>
                <input type="text" name="address_line1" placeholder="Address Line 1" class="box" maxlength="50" value="<?= $fetch_info['address_line1']; ?>" required>
                <input type="text" name="address_line2" placeholder="Address Line 2" class="box" maxlength="50" value="<?= $fetch_info['address_line2']; ?>">
                <input type="text" name="address_line3" placeholder="Address Line 3" class="box" maxlength="50" value="<?= $fetch_info['address_line3']; ?>">

                <div style="margin: 2.6%;"></div>
                <h1 class="text_align_center">Payment Details</h1>
                <div style="margin: 2.6%;"></div>
                
                <input type="radio" name="card_type" class="bullet" value="VISA" required <?= ($fetch_info['card_type'] == 'VISA') ? 'checked' : ''; ?>>
                <img style="margin-right: 13px" class="card_logo" src="../assets/VisaLogo.png" alt="VISA Logo">
                
                <input style="margin-left: 13px" type="radio" name="card_type" value="MasterCard" required <?= ($fetch_info['card_type'] == 'MasterCard') ? 'checked' : ''; ?>>
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

                <input type="number" name="security_code" placeholder="Security Code (CVV)" class="box" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                maxlength = "3" value="<?= $fetch_info['security_code']; ?>" required>

                <?php
                }
                ?>
                <div style="margin: 2.6%;"></div>
                    <a href="cart.php" class="button">Veiw Cart</a>
                    <input type="submit" name="place_order" value="Place Order" class="button">
                </div>

                </form>

            <div class=" clear"></div>
        </div>

        <div style="margin: 8%;"></div>
    </section>
    <!-- Checkout (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>