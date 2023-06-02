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

if (isset($_POST['pay'])) {
    $order_id = $_POST['order_id'];
    $prepare_order = mysqli_query($conn, "UPDATE `orders` SET status = 'Paid' WHERE order_id = '$order_id'") or die('query failed');
    $message[] = 'Paid for Order!';
}

if (isset($_POST['recieve'])) {
    $order_id = $_POST['order_id'];
    $prepare_order = mysqli_query($conn, "UPDATE `orders` SET status = 'Recieved' WHERE order_id = '$order_id'") or die('query failed');
    $message[] = 'Food recieved!';

    $grand_total = 0;
    $total_quantity = 0;
    $budget = 0;
    $fetch_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND status = 'Recieved'") or die('query failed');
    if (mysqli_num_rows($fetch_orders) > 0) {
        while ($orders = mysqli_fetch_assoc($fetch_orders)) {
            $grand_total += ($orders['price'] * $orders['quantity']);
            $total_quantity += $orders['quantity'];
        }
        $budget = $grand_total / $total_quantity;
        // Budget = (Price of Item * Quantity) / Total Items Bought
    }
    $update_budget = mysqli_query($conn, "UPDATE `users` SET budget = $budget WHERE user_id = '$user_id'") or die('query failed');

    $product_id = $_POST['product_id'];
    $time = 0;

    $midnight_lower = strtotime("00:00:00");
    $midnight_upper = strtotime("07:59:59");
    $midnight_orders = 0;

    $morning_lower = strtotime("08:00:00");
    $morning_upper = strtotime("11:59:59");
    $morning_orders = 0;

    $afternoon_lower = strtotime("12:00:00");
    $afternoon_upper = strtotime("15:59:59");
    $afternoon_orders = 0;

    $evening_lower = strtotime("16:00:00");
    $evening_upper = strtotime("19:59:59");
    $evening_orders = 0;

    $night_lower = strtotime("20:00:00");
    $night_upper = strtotime("23:59:59");
    $night_orders = 0;

    $fetch_product = mysqli_query($conn, "SELECT * FROM `orders` WHERE product_id = '$product_id' AND status = 'Recieved'") or die('query failed');
    if (mysqli_num_rows($fetch_product) > 0) {
        while ($product = mysqli_fetch_assoc($fetch_product)) {
            $time = strtotime($product['time_ordered']);

            //Calculate total times ordered at specific times of the day:
            if ($midnight_lower <= $time && $time <= $midnight_upper) {
                $midnight_orders += $product['quantity'];
            }

            if ($morning_lower <= $time && $time <= $morning_upper) {
                $morning_orders += $product['quantity'];
            }

            if ($afternoon_lower <= $time && $time <= $afternoon_upper) {
                $afternoon_orders += $product['quantity'];
            }

            if ($evening_lower <= $time && $time <= $evening_upper) {
                $evening_orders += $product['quantity'];
            }

            if ($night_lower <= $time && $time <= $night_upper) {
                $night_orders += $product['quantity'];
            }


            // If (time_ordered >= strtotime(08:00:00 am) &&
            //     time_ordered <= strtotime(11:59:59 am)
            //     morning_orders_counter += quantity_ordered;
            // }
        }

    }
    $update_midnight_orders = mysqli_query($conn, "UPDATE `products` SET midnight_orders = $midnight_orders WHERE product_id = '$product_id'") or die('query failed');
    $update_morning_orders = mysqli_query($conn, "UPDATE `products` SET morning_orders = $morning_orders WHERE product_id = '$product_id'") or die('query failed');
    $update_afternoon_orders = mysqli_query($conn, "UPDATE `products` SET afternoon_orders = $afternoon_orders WHERE product_id = '$product_id'") or die('query failed');
    $update_evening_orders = mysqli_query($conn, "UPDATE `products` SET evening_orders = $evening_orders WHERE product_id = '$product_id'") or die('query failed');
    $update_night_orders = mysqli_query($conn, "UPDATE `products` SET night_orders = $night_orders WHERE product_id = '$product_id'") or die('query failed');

    /* 
    $time = 0;
    $morning_lower = strtotime("08:00:00");
    $morning_upper = strtotime("12:00:00");
    $morning_orders = 0;
    $orders_data = mysqli_query($conn, "SELECT * FROM `orders` WHERE product_id = '$product_id'") or die('query failed');
    if (mysqli_num_rows($orders_data) > 0) {
        while ($time_ordered = mysqli_fetch_assoc($orders_data)) {
            $time = strtotime($time_ordered['time_ordered']);

            if ($morning_lower <= $time <= $morning_upper) {
                $morning_orders += $product['quantity'];
            }
        }
    }
    $update_morning_orders = mysqli_query($conn, "UPDATE `products` SET morning_orders = $morning_orders WHERE product_id = '$product_id'") or die('query failed');
    */
}

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Orders</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/user_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Cart (Start) -->
    <section class="order_items" style="padding-top: 0;">

        <div class="order_container">
            <h1 class="text_align_center">Ongoing Orders</h1>

            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <?php
            $show_cart = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND NOT status = 'In Cart' AND NOT status = 'Recieved'") or die('query failed');

            if (mysqli_num_rows($show_cart) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($show_cart)) {
                    ?>

                    <div class="food_box">
                        <img src="../assets/food_pictures/<?= $fetch_products['image']; ?>" alt="">

                        <div class="food_details">
                            <div class="food_name">
                                <?= $fetch_products['product_name']; ?>
                            </div>
                            <div class="price"><span>RM</span>
                                <?= $fetch_products['price']; ?>
                            </div>
                            <div class="restaurant_name"><span>From</span>
                                <?= $fetch_products['restaurant_name']; ?>
                            </div>
                        </div>

                        <form action="" method="post" class="">
                            <input type="hidden" name="order_id" value="<?= $fetch_products['order_id']; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
                            <input type="hidden" name="restaurant_id" value="<?= $fetch_products['restaurant_id']; ?>">
                            <input type="hidden" name="restaurant_name" value="<?= $fetch_products['restaurant_name']; ?>">
                            <input type="hidden" name="product_name" value="<?= $fetch_products['product_name']; ?>">
                            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                            <input type="hidden" name="type" value="<?= $fetch_products['type']; ?>">
                            <input type="hidden" name="status" value="<?= $fetch_products['status']; ?>">
                            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                            <div class="order_details text_align_center">
                                <span class="qty_lable">Quantity: </span>
                                <input type="number" name="quantity" class="quantity" min="1" max="99"
                                    value="<?= $fetch_products['quantity']; ?>" maxlength="2" readonly>
                                <div class="text_align_left">
                                    <span class="price_lable">
                                        Sub Total: <br>
                                        RM
                                        <?= $sub_total = ($fetch_products['price'] * $fetch_products['quantity']); ?>
                                    </span>
                                    <span class="status">Status: <br>
                                        <?= $status = ($fetch_products['status']); ?>
                                    </span>
                                </div>
                            </div>
                            <!--
                            <div
                                class="buttons disabled recieve_button <//?= ($fetch_products['status'] == 'Paid') ? 'enabled' : ''; ?>">
                                <button type="submit" name="recieve" onclick="return confirm('Recieved Order?');"><img
                                        src="../assets/icons8-giving-50.png"></button>
                            </div>
                            <div
                                class="buttons disabled pay_button <//?= ($fetch_products['status'] == 'Ready') ? 'enabled' : ''; ?>">
                                <button type="submit" name="pay" onclick="return confirm('Pay for order?');"><img
                                        src="../assets/icons8-pay-50.png"></button>
                            </div>-->
                            <div
                                class="buttons disabled recieve_button <?= ($fetch_products['status'] == 'Ordered') ? 'enabled' : ''; ?>">
                                <button type="submit" name="recieve" onclick="return confirm('Recieved Order?');"><img
                                        src="../assets/icons8-giving-50.png"></button>
                            </div>

                        </form>
                    </div>

                    <div class=" clear"></div>

                    <?php
                }
            } else {
                echo '<p class="text_align_center">No products ordered yet!</p>';
            }
            ?>
        </div>

        <div class="order_container">
            <h1 class="text_align_center">Past Orders</h1>

            <?php
            $show_cart = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' AND NOT status = 'In Cart' AND status = 'Recieved'") or die('query failed');

            if (mysqli_num_rows($show_cart) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($show_cart)) {
                    ?>

                    <div class="food_box">
                        <img src="../assets/food_pictures/<?= $fetch_products['image']; ?>" alt="">

                        <div class="food_details">
                            <div class="food_name">
                                <?= $fetch_products['product_name']; ?>
                            </div>
                            <div class="price"><span>RM</span>
                                <?= $fetch_products['price']; ?>
                            </div>
                            <div class="restaurant_name"><span>From</span>
                                <?= $fetch_products['restaurant_name']; ?>
                            </div>
                        </div>

                        <form action="" method="post" class="">
                            <input type="hidden" name="order_id" value="<?= $fetch_products['order_id']; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
                            <input type="hidden" name="restaurant_id" value="<?= $fetch_products['restaurant_id']; ?>">
                            <input type="hidden" name="restaurant_name" value="<?= $fetch_products['restaurant_name']; ?>">
                            <input type="hidden" name="product_name" value="<?= $fetch_products['product_name']; ?>">
                            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                            <input type="hidden" name="type" value="<?= $fetch_products['type']; ?>">
                            <input type="hidden" name="status" value="<?= $fetch_products['status']; ?>">
                            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                            <div class="order_details text_align_center">
                                <span class="qty_lable">Quantity: </span>
                                <input type="number" name="quantity" class="quantity" min="1" max="99"
                                    value="<?= $fetch_products['quantity']; ?>" maxlength="2" readonly>
                                <div class="text_align_left">
                                    <span class="price_lable">
                                        Sub Total: <br>
                                        RM
                                        <?= $sub_total = ($fetch_products['price'] * $fetch_products['quantity']); ?>
                                    </span>
                                    <span class="status">Status: <br>
                                        <?= $status = ($fetch_products['status']); ?>
                                    </span>
                                </div>
                            </div>
                            <!--
                            <div
                                class="buttons disabled recieve_button <//?= ($fetch_products['status'] == 'Paid') ? 'enabled' : ''; ?>">
                                <button type="submit" name="recieve" onclick="return confirm('Recieved Order?');"><img
                                        src="../assets/icons8-giving-50.png"></button>
                            </div>
                            <div
                                class="buttons disabled pay_button <//?= ($fetch_products['status'] == 'Ready') ? 'enabled' : ''; ?>">
                                <button type="submit" name="pay" onclick="return confirm('Pay for order?');"><img
                                        src="../assets/icons8-pay-50.png"></button>
                            </div>-->

                        </form>
                    </div>

                    <div class=" clear"></div>

                    <?php
                }
            } else {
                echo '<p class="text_align_center">No products ordered yet!</p>';
            }
            ?>
        </div>

        <div style="margin: 8%;"></div>
    </section>
    <!-- Cart (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>