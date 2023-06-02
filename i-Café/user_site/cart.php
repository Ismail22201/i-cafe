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

if (isset($_POST['plus_qty'])) {
    $cart_id = $_POST['cart_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] + 1;
    $update_qty = mysqli_query($conn, "UPDATE `cart` SET quantity = '$quantity' WHERE user_id = '$user_id' AND cart_id = '$cart_id'") or die('query failed');
    $update_qty = mysqli_query($conn, "UPDATE `orders` SET quantity = '$quantity' WHERE product_id = '$product_id' AND status = 'In Cart'") or die('query failed');
    $message[] = 'Quantity updated!';
}

if (isset($_POST['minus_qty'])) {
    $cart_id = $_POST['cart_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'] - 1;
    $update_qty = mysqli_query($conn, "UPDATE `cart` SET quantity = '$quantity' WHERE user_id = '$user_id' AND cart_id = '$cart_id'") or die('query failed');
    $update_qty = mysqli_query($conn, "UPDATE `orders` SET quantity = '$quantity' WHERE product_id = '$product_id' AND status = 'In Cart'") or die('query failed');
    $message[] = 'Quantity updated!';
}

if (isset($_POST['delete'])) {
    $cart_id = $_POST['cart_id'];
    $product_id = $_POST['product_id'];
    $delete_order = mysqli_query($conn, "DELETE FROM `orders` WHERE product_id = '$product_id' AND status = 'In Cart'") or die('query failed');
    $delete_product = mysqli_query($conn, "DELETE FROM `cart` WHERE cart_id = '$cart_id'") or die('query failed');
    $message[] = 'Item deleted!';
}

$grand_total = 0;

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Cart</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/user_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Cart (Start) -->
    <section class="cart_items" style="padding-top: 0;">

        <div class="cart_container ">
            <h1 class="text_align_center">Cart</h1>

            <?php
            if (isset($message)) {
                foreach ($message as $message) {
                    echo '<div class="message">' . $message . '</div>';
                }
            }
            ?>
            <?php
            $grand_total = 0;
            $show_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

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
                            <input type="hidden" name="cart_id" value="<?= $fetch_products['cart_id']; ?>">
                            <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
                            <input type="hidden" name="restaurant_id" value="<?= $fetch_products['restaurant_id']; ?>">
                            <input type="hidden" name="restaurant_name" value="<?= $fetch_products['restaurant_name']; ?>">
                            <input type="hidden" name="product_name" value="<?= $fetch_products['product_name']; ?>">
                            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                            <input type="hidden" name="type" value="<?= $fetch_products['type']; ?>">
                            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                            <div class="order_details text_align_center">
                                <span class="qty_lable">Quantity: </span>
                                <button type="submit" class="minus_qty" name="minus_qty"><img
                                        src="../assets/icons8-minus-30.png"></button>
                                <input type="number" name="quantity" class="quantity" min="1" max="99"
                                    value="<?= $fetch_products['quantity']; ?>" maxlength="2" readonly>
                                <button type="submit" class="plus_qty" name="plus_qty"><img
                                        src="../assets/icons8-plus-30.png"></button>
                                <div class="text_align_left">
                                    <span class="price_lable">
                                        Sub Total: <br>
                                    </span>
                                    <span class="price_lable">
                                        RM
                                        <?= $sub_total = ($fetch_products['price'] * $fetch_products['quantity']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="remove_button">
                                <button type="submit" name="delete" onclick="return confirm('Delete this product?');"><img
                                        src="../assets/icons8-delete-30.png"></button>
                            </div>
                        </form>
                    </div>

                    <div class=" clear"></div>

                    <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="text_align_center">No products added yet!</p>';
            }
            ?>
        </div>
        <div class="cart_container text_align_center">
            <p>Total Cost: <span>RM
                    <?= $grand_total; ?>
                </span></p>
            <a href="checkout.php" class="button <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Checkout</a>
        </div>

        <div style="margin: 8%;"></div>
    </section>
    <!-- Cart (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>