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

if (isset($_POST['add_product'])) {

    $select_restaurant_name = mysqli_query($conn, "SELECT * FROM `restaurants` WHERE restaurant_id = '$restaurant_id'") or die('query failed');
    if (mysqli_num_rows($select_restaurant_name) > 0) {
        $fetch = mysqli_fetch_assoc($select_restaurant_name);
    }
    $restaurant_name = $fetch['restaurant_name'];

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    $temp = explode(".", $_FILES["image"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../assets/food_pictures/' . $newfilename;

    $select = mysqli_query($conn, "SELECT * FROM `products` WHERE product_name = '$product_name'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'Product name already exists!';
    } else {
        if ($image_size > 2000000) {
            $message[] = 'Image size is too large!';
        } else {
            move_uploaded_file($image_tmp_name, $image_folder);

            $insert_product = $conn->prepare("INSERT INTO `products`(restaurant_id, restaurant_name, product_name, price, type, image) VALUES(?,?,?,?,?,?)");
            $insert_product->execute([$restaurant_id, $restaurant_name, $product_name, $price, $type, $newfilename]);

            $message[] = 'New product added!';
        }
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_product_image = mysqli_query($conn, "SELECT * FROM `products` WHERE product_id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_product_image);
    unlink('../assets/food_pictures/' . $fetch_delete_image['image']);
    $delete_product = mysqli_query($conn, "DELETE FROM `products` WHERE product_id = '$delete_id'") or die('query failed');
    //$delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    //$delete_cart->execute([$delete_id]);
    header('location:products.php');
}

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Products</title>
</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/restaurant_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Add Product (Start) -->
    <section class="add_products">

        <h1 class="text_align_center">Products</h1>

        <?php
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message">' . $message . '</div>';
            }
        }
        ?>

        <div class="add_products_container text_align_center">
            <h1 class="text_align_center">Add Product</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <input type="text" required placeholder="Enter Product Name" name="product_name" maxlength="100"
                    class="box">
                <input type="decimal" min="0" max="9999999999" required placeholder="Enter Price" name="price"
                    onkeypress="if(this.value.length == 10) return false;" class="box">
                <select name="type" required>
                    <option value="" disabled selected>Food Type</option>
                    <option value="Main Dish">Main Dish</option>
                    <option value="Fast Food">Fast Food</option>
                    <option value="Drinks">Drinks</option>
                    <option value="Desserts">Desserts</option>
                </select>
                <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp"
                    required>
                <input type="submit" value="Add product" name="add_product" class="button add_products_button">
            </form>

            <div class="clear"></div>
        </div>

    </section>
    <!-- Add Product (Start) -->

    <!-- Product List (Start) -->
    <section class="products_list" style="padding-top: 0;">

        <div class="food_container">
            <h1 class="text_align_center">List of Products</h1>

            <?php
            $show_products = mysqli_query($conn, "SELECT * FROM `products` WHERE restaurant_id = '$restaurant_id'") or die('query failed');

            if (mysqli_num_rows($show_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($show_products)) {
                    ?>
                    <div class="food_box">
                        <img src="../assets/food_pictures/<?= $fetch_products['image']; ?>" alt="">
                        <div class="food_name">
                            <?= $fetch_products['product_name']; ?>
                        </div>

                        <div class="food_details">
                            <div class="price"><span>RM</span>
                                <?= $fetch_products['price']; ?>
                            </div>
                            <div class="category">
                                <?= $fetch_products['type']; ?>
                            </div>
                        </div>

                        <div class="buttons text_align_center">
                            <a href="update_product.php?update=<?= $fetch_products['product_id']; ?>"
                                class="button update_button">Update</a>
                            <a href="products.php?delete=<?= $fetch_products['product_id']; ?>" class="button delete_button"
                                onclick="return confirm('Delete this product?');">Delete</a>

                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="text_align_center">No products added yet!</p>';
            }
            ?>
            <div class="clear"></div>
        </div>
        <div style="margin: 8%;"></div>
    </section>
    <!-- Product List (Start) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>