<?php
    session_start();
    include_once "./dbconnect.php";
    $email=$_SESSION['email'];
  
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
        <link rel="stylesheet"href="style-cart.css">
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
                <div class="container py-5">
                    <div class="row d-flex justify-content-center my-4">
                        <div class="col-md-8">
                            <div class="card mb-4">
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
                                                <label class="form-label" for="qty">Quantity</label>
                                                    <input  min="1" name="quantity" value="<?php echo $row1['quantity']?>" id ="qty" name="qty"type="number" max="<?php echo $row1['total_quantity']?>"class="form-control" />
                                                    <input type="hidden" name="enid" value="<?php echo $row1['entry_id']?>">
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
                                         
                            </div>
                        </div>
                            <div class="col-md-4" id="total" name="total">
                                <div class="card mb-4">
                                    <div class="card-header py-3">
                                        <h5 class="mb-0">Summary</h5>
                                    </div>
                                    <div class="card-body">
                                    <?php
                                        $sql1="SELECT net_total, user_id from cart where cart.user_id=(select user_id from users where email='$email') and cart.is_checked_out=0";
                                        $res = $conn-> query($sql1);
                                        $total=0;
                                        $user_id=0;
                                        if ($res-> num_rows > 0){
                                            while($row1 = $res-> fetch_assoc()){
                                                $total=$total+$row1['net_total'];
                                                $user_id=$row1['user_id'];
                                            }}
                                           
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
                                        <a href="checkout.php?user=<?php echo $user_id;?>"><button type="button" id="checkout"class="btn btn-primary btn-lg btn-block">Checkout</button>
                                    
                                     
                                    </div>
                                </div>
                            </div>
                        </div>               
                    </div>
                </div>
            </section>  
        </main>
        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/Headroom.js"></script>
        <script src="js/jQuery.headroom.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/custom.js"></script>
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
        $(document).ready(function(){
            $('#checkout').on('click', function(){
                var userid = $(this).val();
                if(userid){
                    $.ajax({
                        type:'POST',
                        url:'checkout.php',
                        data:'userid='+userid,
                        success:function(html){
                            
                        }
                    }); 
                }else{
                    
                }
            });
            
        });
        $(document).ready(function(){
            $('#qty').on('change', function(){
                var qty = $(this).val();
                var enid = $('#enid').val();
                if(qty){
                    $.ajax({
                        type:'POST',
                        url:'updateqty.php',
                        data:'{ "qty":' + qty + ', "enid":'+ enid +' }',
                        success:function(html){
                            $('#total').html(html); 
                        }
                    }); 
                }else{
                    
                }
            });
            
        });
        </script>
    </body>
</html>