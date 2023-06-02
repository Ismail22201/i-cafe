<header>
    <section class="navigation_bar">
        <div class="menu_bar">
            <div class="logo">
                <a href="home.php" title="Logo">
                    <img src="../assets/logo_white.png" alt="i-Cafe Logo" class="responsive_image">
                </a>
            </div>
            <div class="profile dropdown">
                <?php
                $select = mysqli_query($conn, "SELECT * FROM `restaurants` WHERE restaurant_id = '$restaurant_id'") or die('query failed');
                if (mysqli_num_rows($select) > 0) {
                    $fetch = mysqli_fetch_assoc($select);
                }
                if ($fetch['image'] == '') {
                    echo '<a href="restaurant_profile.php"><img src="../assets/profile_pictures/default-avatar.png"></a>';
                } else {
                    echo '<a href="restaurant_profile.php"><img src="../assets/profile_pictures/' . $fetch['image'] . '"></a>';
                }
                ?>
                <h3>
                    <?php echo '<a href="restaurant_profile.php" class="dropbtn">' . $fetch['restaurant_name'] . '</a>' ?>
                </h3>
                <div class="dropdown-content">
                    <a href="restaurant_profile.php">Profile</a>
                    <a href="restaurant_panel.php?logout=<?php echo $restaurant_id; ?>">Logout</a>
                </div>
            </div>

            <div class="restaurant_navigation_links text_align_left">
                <ul>
                    <li>
                        <a href="restaurant_panel.php">Dashboard</a>
                    </li>
                    <li>
                        <a href="products.php">Products</a>
                    </li>
                    <li>
                        <a href="restaurant_orders.php">Orders</a>
                    </li>
                </ul>
            </div>

            <div class="clear"></div>
        </div>
        <div style="margin: 7%;"></div>
    </section>
</header>