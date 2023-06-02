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

if (isset($_POST['prepare'])) {
    $order_id = $_POST['order_id'];
    $prepare_order = mysqli_query($conn, "UPDATE `orders` SET status = 'Preparing' WHERE order_id = '$order_id'") or die('query failed');
    $message[] = 'Preparing order!';
}

if (isset($_POST['ready'])) {
    $order_id = $_POST['order_id'];
    $prepare_order = mysqli_query($conn, "UPDATE `orders` SET status = 'Ready' WHERE order_id = '$order_id'") or die('query failed');
    $message[] = 'Order is ready!';
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
    <?php include '../components/restaurant_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Cart (Start) -->
    <section class="order_items" style="padding-top: 0;">

        <div class="order_container ">
            <h1 class="text_align_center">Ongoing Orders</h1>

            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <?php
            $show_cart = mysqli_query($conn, "SELECT * FROM `orders` WHERE restaurant_id = '$restaurant_id' AND NOT status = 'In Cart' AND NOT status = 'Recieved'") or die('query failed');

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
                            <div
                                class="buttons disabled ready_button <?= ($fetch_products['status'] == 'Preparing') ? 'enabled' : ''; ?>">
                                <button type="submit" name="ready" onclick="return confirm('Order is ready?');"><img
                                        src="../assets/icons8-take-away-food-50.png"></button>
                            </div>
                            <div
                                class="buttons disabled prepare_button <?= ($fetch_products['status'] == 'Ordered') ? 'enabled' : ''; ?>">
                                <button type="submit" name="prepare"
                                    onclick="return confirm('Accept and prepare this order?');"><img
                                        src="../assets/icons8-frying-pan-50.png"></button>
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

        <div class="order_container ">
            <h1 class="text_align_center">Past Orders</h1>

            <?php
            $show_cart = mysqli_query($conn, "SELECT * FROM `orders` WHERE restaurant_id = '$restaurant_id' AND NOT status = 'In Cart' AND status = 'Recieved'") or die('query failed');

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
                            <div
                                class="buttons disabled ready_button <?= ($fetch_products['status'] == 'Preparing') ? 'enabled' : ''; ?>">
                                <button type="submit" name="ready" onclick="return confirm('Order is ready?');"><img
                                        src="../assets/icons8-take-away-food-50.png"></button>
                            </div>
                            <div
                                class="buttons disabled prepare_button <?= ($fetch_products['status'] == 'Ordered') ? 'enabled' : ''; ?>">
                                <button type="submit" name="prepare"
                                    onclick="return confirm('Accept and prepare this order?');"><img
                                        src="../assets/icons8-frying-pan-50.png"></button>
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


        <div style="margin: 8%;"></div>
    </section>
    <!-- Cart (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>