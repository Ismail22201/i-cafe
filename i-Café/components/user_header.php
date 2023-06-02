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
                $select = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = '$user_id'") or die('query failed');
                if (mysqli_num_rows($select) > 0) {
                    $fetch = mysqli_fetch_assoc($select);
                }
                if ($fetch['image'] == '') {
                    echo '<a href="user_profile.php"><img src="../assets/profile_pictures/default-avatar.png"></a>';
                } else {
                    echo '<a href="user_profile.php"><img src="../assets/profile_pictures/' . $fetch['image'] . '"></a>';
                }
                ?>
                <h3>
                    <?php echo '<a href="user_profile.php" class="dropbtn">' . $fetch['user_name'] . '</a>' ?>
                </h3>
                <div class="dropdown-content">
                    <a href="user_profile.php">Profile</a>
                    <a href="home.php?logout=<?php echo $user_id; ?>">Logout</a>
                </div>
            </div>
            <div class="search_bar">
                <form action="search_food.html" method="post">
                    <input type="search" name="search" placeholder="What would you like to eat?" required>
                    <input type="submit" name="submit" value="Search" class="button search_button">
                </form>
            </div>

            <div class="navigation_links text_align_right">
                <ul>
                    <li>
                        <a href="home.php">Home</a>
                    </li>
                    <li>
                        <a href="menu.php">Menu</a>
                    </li>
                    <li>
                        <a href="cart.php">Cart</a>
                    </li>
                    <li>
                        <a href="user_orders.php">Orders</a>
                    </li>
                    <li>
                        <a href="#">Rewards</a>
                    </li>
                </ul>
            </div>

            <div class="clear"></div>
        </div>
        <div style="margin: 7%;"></div>
    </section>
</header>