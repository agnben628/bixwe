<?php
    session_start();
    include_once "./dbconnect.php";
    $email=$_SESSION['email'];
    $user=$_GET['user'];
$grand_total = 0;

if (!isset($_SESSION["email"])) {
    header("Location:login.php");
}

if (isset($_POST['submit'])) {
    $order_date = date("Y-m-d H:i:s");
    $customer_name = $_POST['name'];
    $customer_email = $_POST['email'];
    $customer_phone = $_POST['phone'];
    $customer_address = $_POST['address'];
    $payment_mode = $_POST['payment_mode'];
    $total_amount = $_POST['total_amount'];
    //Insert to orders table
    $sql = "INSERT INTO orders (user_id, order_date, c_name, c_email, c_phone, c_address, payment_mode, total_amount) VALUES ($user, '$order_date', '$customer_name', '$customer_email', '$customer_phone', '$customer_address', '$payment_mode', '$total_amount')";
    $result = mysqli_query($conn, $sql);
    $order_id = mysqli_insert_id($conn);
    if (!empty($order_id)) {
        foreach ($_POST['items'] as $key => $product_id) {
            $id = $_POST['entry_ids'][$key];
            $quantity = $_POST['quantity'][$key];
            $price = $_POST['price'][$key];
            $total_price = $quantity * $price;
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price, total_price) VALUES ('$order_id', '$product_id', '$quantity', '$price', '$total_price')";
            $result = mysqli_query($conn, $sql);
            // update cart table status
            $sql = "UPDATE cart SET is_checked_out = 1 WHERE entry_id = $id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // reduce Total_quantity from product table
                $sql = "UPDATE product SET total_quantity = total_quantity - $quantity WHERE product_id = $product_id";
                $result = mysqli_query($conn, $sql);
            }
        }
        header("Location:products.php");
    }
}

$sql1 = mysqli_query($conn,"SELECT c.entry_id, c.product_id, p.product_name, c.quantity, p.price FROM cart c INNER JOIN product p ON p.product_id = c.product_id WHERE c.user_id=" . $user . " AND c.is_checked_out=0");
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Cart</title>
        <!-- CSS FILES -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="prostyle.css">
        <link rel="stylesheet" href="css/slick.css"/>
        <link href="stylecat.css" rel="stylesheet">
        <link rel="stylesheet" href="navstyle.css">
        <link rel="stylesheet"href="buttonstyle.css">
        <link href="style-homepage.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <nav class="navbar navbar-expand-lg" id="nav1">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand" href="homepage.php">
                        <strong><span>Bix</span>we</strong>
                    </a>
                    &emsp;&emsp;
                    <div class="d-lg-none">
                        <div class="navbar-nav dropdown">
                            <?php
                                $sql="SELECT * from category";
                                $result = $conn-> query($sql);
                                if ($result-> num_rows > 0){
                                while($row = $result-> fetch_assoc()){
                                ?>
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="category.php?category=<?php echo $row['category_id'];?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?php echo $row['category_name']; 
                                ?>
                                </a>
                                <?php $cat=$row['category_id'];?>
                                </li>
                                <?php
                                }
                                }
                            ?>
                        </div>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <form class="form-inline">
                            <input type="search" class="form-control ds-input" id="search-input" placeholder="Search..." aria-label="Search for..." autocomplete="off" spellcheck="false" 
                            role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
                        </form>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <a href="curate.php" class="bi bi-collection custom-icon me-5"></a>
                        <a href="cart.php" class="bi bi-cart2 custom-icon me-5"></a>
                        <a href="profile.php" class="bi-person custom-icon me-5"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        &emsp;&emsp;
                        <ul class="navbar-nav">
                            <?php
                            $sql="SELECT * from category";
                            $result = $conn-> query($sql);
                            if ($result-> num_rows > 0){
                            while($row = $result-> fetch_assoc()){
                            ?>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="category.php?category=<?php echo $row['category_id'];?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $row['category_name']; 
                            ?>
                            </a>
                            <?php $cat=$row['category_id'];?>
                            </li>
                            <?php
                            }
                            }
                            ?>
                        </ul>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <form class="form-inline">
                            <input type="search" class="form-control ds-input" id="search-input" placeholder="Search..." aria-label="Search for..." autocomplete="off" spellcheck="false" 
                            role="combobox" aria-autocomplete="list" aria-expanded="false" aria-owns="algolia-autocomplete-listbox-0" dir="auto" style="position: relative; vertical-align: top;">
                        </form>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        <a href="curate.php" class="bi bi-collection custom-icon me-5"></a>
                        <a href="cart.php" class="bi bi-cart2 custom-icon me-5"></a>
                        <a href="profile.php" class="bi-person custom-icon me-5"></a>
                    </div>
                </div>
            </nav>     
                        </br></br></br></br>
            <section class="h-100 gradient-custom">
                <form method="post" id="placeOrder">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6 px-4 pb-4" id="order">

                                <div class="container">
                        </br></br>
                                    <h4>Order Details</h4>
                                    </br>
                                    <?php
                                    while ($row = mysqli_fetch_array($sql1)) {
                                        $sub_total = $row['quantity'] * $row['price'];
                                        $grand_total += $sub_total;
                                        ?>
                                        <input type="hidden" name="items[]" value="<?= $row['product_id'] ?>">
                                        <input type="hidden" name="quantity[]" value="<?= $row['quantity'] ?>">
                                        <input type="hidden" name="price[]" value="<?= $row['price'] ?>">
                                        <input type="hidden" name="entry_ids[]" value="<?= $row['entry_id'] ?>">
                                        <p><?= $row['product_name'] ?> <span class="price">₹ <?= $sub_total ?></span></p>
                                        <?php
                                    } ?>
                                    <hr class="hr">
                                    <p>Total <span class="price" style="color:black"><b>₹ <?= $grand_total ?></b></span></p>
                                </div>

                                <input type="hidden" name="total_amount" value="<?= $grand_total; ?>">
                                </br>
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Enter Name"  minlength="5"
                    maxlength="50" pattern="\S(.*\S)?" required>
                                </div>
                                </br>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Enter E-Mail"  required>
                                </div>
                                </br>
                                <div class="form-group">
                                    <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" pattern="[6-9]{1}[0-9]{9}" 
                    title="Phone number with 7-9 and remaing 9 digit with 0-9" required>
                                </div>
                                </br>
                                <div class="form-group">
                                    <textarea name="address" class="form-control" rows="3" cols="10"
                                            placeholder="Enter Delivery Address Here..."></textarea>
                                </div>
                                </br>
                                
                                <div class="form-group">
                                    <select name="payment_mode" class="form-control" required>
                                        <option value="" selected disabled>Payment Mode</option>
                                        <option value="1">Cash On Delivery</option>
                                    </select>
                                </div>
                                </br>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>  
        </main>
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/Headroom.js"></script>
        <script src="js/jQuery.headroom.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/custom.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>
    </body>
</html>