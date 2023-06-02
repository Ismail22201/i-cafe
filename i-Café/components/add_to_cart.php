<?php

if (isset($_POST['add_to_cart'])) {

    if ($user_id == '') {
        header('location:../all_users/login.php');
    } else {

        $user_emotion = $_POST['user_emotion'];
        $user_emotion = filter_var($user_emotion, FILTER_SANITIZE_STRING);
        $product_id = $_POST['product_id'];
        $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
        $restaurant_id = $_POST['restaurant_id'];
        $restaurant_id = filter_var($restaurant_id, FILTER_SANITIZE_STRING);
        $restaurant_name = $_POST['restaurant_name'];
        $restaurant_name = filter_var($restaurant_name);
        $product_name = $_POST['product_name'];
        $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $type = $_POST['type'];
        $type = filter_var($type, FILTER_SANITIZE_STRING);
        $quantity = $_POST['quantity'];
        $quantity = filter_var($quantity, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_cart_numbers) > 0) {
            $message[] = 'Already added to cart!';
        } else {

            //mysqli_query($conn, "INSERT INTO `cart`(user_name, email, password, image) VALUES('$user_name', '$email', '$pass', '$image')") or die('query failed');

            mysqli_query($conn, "INSERT INTO `cart`(user_id, user_emotion, product_id, restaurant_id, restaurant_name, product_name, price, type, quantity, image) VALUES('$user_id', '$user_emotion', '$product_id', '$restaurant_id', '$restaurant_name', '$product_name', '$price', '$type', '$quantity', '$image')");
            mysqli_query($conn, "INSERT INTO `orders`(user_id, user_emotion, product_id, restaurant_id, restaurant_name, product_name, price, type, quantity, image) VALUES('$user_id', '$user_emotion', '$product_id', '$restaurant_id', '$restaurant_name', '$product_name', '$price', '$type', '$quantity', '$image')");


            /*
            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, user_emotion, product_id, restaurant_id, restaurant_name, product_name, price, type, quantity, image) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $insert_cart->execute([$user_id, $user_emotion, $product_id, $restaurant_id, $restaurant_name, $product_name, $price, $type, $quantity, $image]);

            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, user_emotion, product_id, restaurant_id, restaurant_name, product_name, price, type, quantity, image) VALUES(?,?,?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $user_emotion, $product_id, $restaurant_id, $restaurant_name, $product_name, $price, $type, $quantity, $image]);
            */
            $message[] = 'Added to cart!';

        }

    }

}

?>
<html>

<body>
    <div class="text_align_center cart">
        <?php
        $count_cart_items = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
        $total_cart_items = mysqli_num_rows($count_cart_items)
            ?>
        <a href="cart.php"><img src="../assets/icons8-shopping-cart-30.png"></a>
        <p class="total_cart_items">
            <?= $total_cart_items; ?>
        </p>
    </div>

</body>

</html>