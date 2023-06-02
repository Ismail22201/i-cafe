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

include '../components/add_to_cart.php';

?>

<!DOCTYPE html>

<html>

<head>
    <?php include '../components/head.php' ?>
    <title>i-Cafe | Home</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@2.4.0/dist/tf.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@tensorflow-models/face-landmarks-detection@0.0.1/dist/face-landmarks-detection.js"></script>

</head>

<body>

    <!-- Navigation Bar (Start) -->
    <?php include '../components/user_header.php' ?>
    <!-- Navigation Bar (End) -->

    <!-- Menu (Start) -->
    <section class="products_list" style="padding-top: 0;">

    <?php
        //Sort sequentially from top:
        //$show_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        
        //Sort based on popularity:
        //$show_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY popularity DESC") or die('query failed');
        
        //Calculate popularity based on the time:
        date_default_timezone_set("Singapore");
        $current_time = strtotime("Now");
        $times_ordered = 0;
        $popularity = 0;

        $midnight_lower = strtotime("00:00:00");
        $midnight_upper = strtotime("07:59:59");

        $morning_lower = strtotime("08:00:00");
        $morning_upper = strtotime("11:59:59");

        $afternoon_lower = strtotime("12:00:00");
        $afternoon_upper = strtotime("15:59:59");

        $evening_lower = strtotime("16:00:00");
        $evening_upper = strtotime("19:59:59");

        $night_lower = strtotime("20:00:00");
        $night_upper = strtotime("23:59:59");

        $product_data = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
        if (mysqli_num_rows($product_data) > 0) {
            while ($product = mysqli_fetch_assoc($product_data)) {
                $product_id = $product['product_id'];
                $times_ordered = $product['times_ordered'];

                $midnight_orders = $product['midnight_orders'];
                $morning_orders = $product['morning_orders'];
                $afternoon_orders = $product['afternoon_orders'];
                $evening_orders = $product['evening_orders'];
                $night_orders = $product['night_orders'];

                $times_ordered = $midnight_orders + $morning_orders + $afternoon_orders + $evening_orders + $night_orders;

                if ($midnight_lower <= $current_time && $current_time <= $midnight_upper) {
                    $popularity = $times_ordered + $midnight_orders;
                }

                if ($morning_lower <= $current_time && $current_time <= $morning_upper) {
                    $popularity = $times_ordered + $morning_orders;
                }

                if ($afternoon_lower <= $current_time && $current_time <= $afternoon_upper) {
                    $popularity = $times_ordered + $afternoon_orders;
                }

                if ($evening_lower <= $current_time && $current_time <= $evening_upper) {
                    $popularity = $times_ordered + $evening_orders;
                }

                if ($night_lower <= $current_time && $current_time <= $night_upper) {
                    $popularity = $times_ordered + $night_orders;
                }

                $update_times_ordered = mysqli_query($conn, "UPDATE `products` SET times_ordered = $times_ordered WHERE product_id = '$product_id'") or die('query failed');
                $update_popularity = mysqli_query($conn, "UPDATE `products` SET popularity = $popularity WHERE product_id = '$product_id'") or die('query failed');
            }
        }

        //Get users budget:
        $user_data = mysqli_query($conn, "SELECT * FROM `users` WHERE user_id = $user_id") or die('query failed');
        $budget = 0;
        $budget_lower = 0;
        $budget_upper = 0;

        if (mysqli_num_rows($user_data) > 0) {
            while ($user_budget = mysqli_fetch_assoc($user_data)) {
                $budget = $user_budget['budget'];
            }
        }

        $budget_lower = $budget - 1;
        $budget_upper = $budget + 1;
    
        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message">' . $message . '</div>';
            }
        }

        if ($budget != 0){
        ?>
        <div class="food_container">
            <h1 class="text_align_center">Recommendations</h1>
            <?php
            $show_products = mysqli_query($conn, "SELECT * FROM `products` WHERE price BETWEEN $budget_lower AND $budget_upper ORDER BY popularity DESC") or die('query failed');

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
                                <div class="restaurant_name">
                                    <?= $fetch_products['restaurant_name']; ?>
                                </div>
                            </div>
    
                            <form action="" method="post" class="">
                                <input type="hidden" name="user_emotion" class="user_emotion" value="">
                                <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
                                <input type="hidden" name="restaurant_id" value="<?= $fetch_products['restaurant_id']; ?>">
                                <input type="hidden" name="restaurant_name" value="<?= $fetch_products['restaurant_name']; ?>">
                                <input type="hidden" name="product_name" value="<?= $fetch_products['product_name']; ?>">
                                <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                                <input type="hidden" name="type" value="<?= $fetch_products['type']; ?>">
                                <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                                <div class="buttons text_align_center">
                                    <input type="number" name="quantity" class="quantity" min="1" max="99" value="1" maxlength="2">
                                    <button type="submit" name="add_to_cart" class="button add_to_cart_button">Add To
                                        Cart</button>
                                </div>
    
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="text_align_center">No products added yet!</p>';
                }
                ?>
            <div class=" clear">
            </div>
        </div>
    <?php
    }
    ?>
        <div class="food_container">
            <h1 class="text_align_center">Menu</h1>
            <?php
            $show_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY popularity DESC") or die('query failed');

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
                                <div class="restaurant_name">
                                    <?= $fetch_products['restaurant_name']; ?>
                                </div>
                            </div>
    
                            <form action="" method="post" class="">
                                <input type="hidden" name="user_emotion" class="user_emotion" value="">
                                <input type="hidden" name="product_id" value="<?= $fetch_products['product_id']; ?>">
                                <input type="hidden" name="restaurant_id" value="<?= $fetch_products['restaurant_id']; ?>">
                                <input type="hidden" name="restaurant_name" value="<?= $fetch_products['restaurant_name']; ?>">
                                <input type="hidden" name="product_name" value="<?= $fetch_products['product_name']; ?>">
                                <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                                <input type="hidden" name="type" value="<?= $fetch_products['type']; ?>">
                                <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                                <div class="buttons text_align_center">
                                    <input type="number" name="quantity" class="quantity" min="1" max="99" value="1" maxlength="2">
                                    <button type="submit" name="add_to_cart" class="button add_to_cart_button">Add To
                                        Cart</button>
                                </div>
    
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="text_align_center">No products added yet!</p>';
                }
                ?>
            <div class=" clear">
            </div>
        </div>
        <div style="margin: 8%;"></div>
    </section>
    <!-- Menu (End) -->

    <!-- Emotion Detector (Start) -->
    <video id="webcam" style="
                            visibility: hidden;
                            width: 0px;
                            height: 0px;
                            ">
    </video>
    <script>
        let detected_emotion = null;

        function setText(text) {
            document.getElementById("status").innerText = text;
            //document.getElementById('user_emotion').value = text;

            var list = document.querySelectorAll('.user_emotion');
            var n;
            for (n = 0; n < list.length; ++n) {
                list[n].value = text;
            }

            //document.getElementsByClassName('user_emotion').value = text;
            //window.location.href = window.location.href + '?text=' + text;
            //document.cookie = "text = " + text;
        }

        function drawLine(ctx, x1, y1, x2, y2) {
            ctx.beginPath();
            ctx.moveTo(x1, y1);
            ctx.lineTo(x2, y2);
            ctx.stroke();
        }

        async function setupWebcam() {
            return new Promise((resolve, reject) => {
                const webcamElement = document.getElementById("webcam");
                const navigatorAny = navigator;
                navigator.getUserMedia = navigator.getUserMedia ||
                    navigatorAny.webkitGetUserMedia || navigatorAny.mozGetUserMedia ||
                    navigatorAny.msGetUserMedia;
                if (navigator.getUserMedia) {
                    navigator.getUserMedia({ video: true },
                        stream => {
                            webcamElement.srcObject = stream;
                            webcamElement.addEventListener("loadeddata", resolve, false);
                        },
                        error => reject());
                }
                else {
                    reject();
                }
            });
        }

        const emotions = ["Angry", "Disgust", "Fear", "Happy", "Neutral", "Sad", "Surprise"];
        let emotionModel = null;

        let output = null;
        let model = null;

        async function predictEmotion(points) {
            let result = tf.tidy(() => {
                const xs = tf.stack([tf.tensor1d(points)]);
                return emotionModel.predict(xs);
            });
            let prediction = await result.data();
            result.dispose();
            // Get the index of the maximum value
            let id = prediction.indexOf(Math.max(...prediction));
            return emotions[id];
        }

        async function trackFace() {
            const video = document.querySelector("video");
            const faces = await model.estimateFaces({
                input: video,
                returnTensors: false,
                flipHorizontal: false,
            });
            //output.drawImage(
            //    video,
            //    0, 0, video.width, video.height,
            //    0, 0, video.width, video.height
            //);

            let points = null;
            faces.forEach(face => {
                // Draw the bounding box
                const x1 = face.boundingBox.topLeft[0];
                const y1 = face.boundingBox.topLeft[1];
                const x2 = face.boundingBox.bottomRight[0];
                const y2 = face.boundingBox.bottomRight[1];
                const bWidth = x2 - x1;
                const bHeight = y2 - y1;
                //drawLine(output, x1, y1, x2, y1);
                //drawLine(output, x2, y1, x2, y2);
                //drawLine(output, x1, y2, x2, y2);
                //drawLine(output, x1, y1, x1, y2);

                // Add just the nose, cheeks, eyes, eyebrows & mouth
                const features = [
                    "noseTip",
                    "leftCheek",
                    "rightCheek",
                    "leftEyeLower1", "leftEyeUpper1",
                    "rightEyeLower1", "rightEyeUpper1",
                    "leftEyebrowLower", //"leftEyebrowUpper",
                    "rightEyebrowLower", //"rightEyebrowUpper",
                    "lipsLowerInner", //"lipsLowerOuter",
                    "lipsUpperInner", //"lipsUpperOuter",
                ];
                points = [];
                features.forEach(feature => {
                    face.annotations[feature].forEach(x => {
                        points.push((x[0] - x1) / bWidth);
                        points.push((x[1] - y1) / bHeight);
                    });
                });
            });

            if (points) {
                detected_emotion = await predictEmotion(points);
                setText(`${detected_emotion}`);

            }
            else {
                setText("No Face");
            }

            requestAnimationFrame(trackFace);
        }

        (async () => {
            await setupWebcam();
            const video = document.getElementById("webcam");
            video.play();
            //let videoWidth = video.videoWidth;
            //let videoHeight = video.videoHeight;
            //ideo.width = videoWidth;
            //video.height = videoHeight;

            //let canvas = document.getElementById("output");
            //canvas.width = video.width;
            //canvas.height = video.height;

            //output = canvas.getContext("2d");
            //output.translate(canvas.width, 0);
            //output.scale(-1, 1); // Mirror cam
            //output.fillStyle = "#fdffb6";
            //output.strokeStyle = "#fdffb6";
            //output.lineWidth = 2;

            // Load Face Landmarks Detection
            model = await faceLandmarksDetection.load(
                faceLandmarksDetection.SupportedPackages.mediapipeFacemesh
            );
            // Load Emotion Detection
            emotionModel = await tf.loadLayersModel('web/model/facemo.json');

            setText("Loaded!");

            trackFace();
        })();
    </script>
    <!--<span id="status">Loading...</span>-->
    <!-- Emotion Detector (End) -->

    <!-- Footer (Start) -->
    <?php include '../components/footer.php' ?>
    <!-- Footer (End) -->

</body>

</html>