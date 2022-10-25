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
        <link rel="stylesheet"href="style-cart.css">
        <link href="style-homepage.css" rel="stylesheet">
    </head>
<?php 
// Include the database config file 
session_start();
include_once "./dbconnect.php";
$email=$_SESSION['email'];
?>
<div class="card mb-4">
                                    <div class="card-header py-3">
                                        <h5 class="mb-0">Summary</h5>
                                    </div>
                                    <div class="card-body">
                                    <?php
                                        $sql1="SELECT net_total from cart where cart.user_id=(select user_id from users where email='$email') and cart.is_checked_out=0";
                                        $res = $conn-> query($sql1);
                                        $total=0;
                                        $user=0;
                                        if ($res-> num_rows > 0){
                                            while($row1 = $res-> fetch_assoc()){
                                                $total=$total+$row1['net_total'];
                                                $user=$row1['user_id'];
                                            }
                                        }
                                    ?>
                                        <ul class="list-group list-group-flush">
                                            <li
                                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                                            Products
                                            <span>₹ <?php echo $total;?></span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            Shipping
                                            <span>Free</span>
                                            </li>
                                            <li
                                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                            <div>
                                                <strong>Total amount</strong>
                                                <strong>
                                                    <p class="mb-0">(including VAT)</p>
                                                </strong>
                                            </div>
                                            <span><strong>₹ <?php echo $total;?></strong></span>
                                            </li>
                                        </ul>
                                        <a href="checkout.php?user=<?php echo $user?>"><button type="button" id="checkout"class="btn btn-primary btn-lg btn-block">Checkout</button></a>
                                    </div>