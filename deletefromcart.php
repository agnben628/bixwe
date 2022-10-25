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
if(!empty($_POST["enid"])){ 
    // Fetch state data based on the specific country 
    $enid= $_POST['enid'];
    $query = "DELETE FROM cart WHERE entry_id = $enid";
    $result = $conn->query($query);  
    if($result)
        echo'<script>alert("Product removed from cart!")</script>';
        else
        echo'<script>alert("Product could not be removed from cart!")</script>';
}  
?> 
                    <div class="card-body" id="product-disp" name="product-disp">
                                    <!-- Single item -->
                                    <?php
                                        $sql1="SELECT * from product, color, sizes, cart where cart.user_id=(select user_id from users where email='$email') and cart.product_id=product.product_id and cart.color_id=color.color_id and cart.size_id=sizes.size_id and cart.is_checked_out=0";
                                        $res = $conn-> query($sql1);
                                        if ($res-> num_rows > 0){
                                            while($row1 = $res-> fetch_assoc()){
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                            <!-- Image -->
                                            <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                                <img src="<?php echo $row1['image1']?>"
                                                class="w-100" alt="" />
                                                <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                                </a>
                                            </div>
                                            <!-- Image -->
                                        </div>
                                        <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                            <!-- Data -->
                                            <p><strong><?php echo $row1['product_name']?></strong></p>
                                            <p>Color: <?php echo $row1['color_name']?></p>
                                            <p>Size: <?php echo $row1['size_name']?></p>
                                            <button type="button" class="btn btn-primary btn-sm me-1 mb-2" id="delete" name="delete" value="<?php echo $row1['entry_id']?>"data-mdb-toggle="tooltip"
                                                title="Remove item">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm mb-2" data-mdb-toggle="tooltip"
                                                title="Move to the wish list">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            <!-- Data -->
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                            <!-- Quantity -->
                                            &emsp;&emsp;
                                            <div class="d-flex mb-4" style="max-width: 300px">
                                            &emsp;&emsp;&emsp;&emsp;&emsp;
                                                <div class="form-outline">
                                                <label class="form-label" for="form1">Quantity</label>
                                                    <input id="form1" min="1" name="quantity" value="<?php echo $row1['quantity']?>" type="number" max="<?php echo $row1['total_quantity']?>"class="form-control" />
                                                    
                                                </div>
                                                
                                            </div>
                                            <!-- Quantity -->
                                            <!-- Price -->
                                            <p class="text-start text-md-center">
                                            <label class="form-label" for="price">Price: </label>
                                                <strong>₹ <?php echo $row1['price']?></strong>
                                            </p>
                                            <!-- Price -->
                                        </div>
                                    </div>
                                    <hr class="my-4" />
                                    <!-- Single item -->
                                    <?php
                                    }
                                    }
                                    ?>
                                </div> 
                                <script>
        $(document).ready(function(){
            $('#delete').on('click', function(){
                var enID = $(this).val();
                if(enID){
                    $.ajax({
                        type:'POST',
                        url:'deletefromcart.php',
                        data:'enid='+enID,
                        success:function(html){
                            $('#product-disp').html(html); 
                        }
                    }); 
                }else{
                    
                }
            });
            
        });
        $(document).ready(function(){
            $('#delete').on('click', function(){
                var enID = $(this).val();
                if(enID){
                    $.ajax({
                        type:'POST',
                        url:'updatetotal.php',
                        data:'enid='+enID,
                        success:function(html){
                            $('#total').html(html); 
                        }
                    }); 
                }else{
                    
                }
            });
            
        });
        </script>