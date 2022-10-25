<?php 
session_start();
include_once "./dbconnect.php";
$product=$_GET['products'];
$email=$_SESSION['email'];
if(isset($_POST['add_to_cart']))
{
    $user=$_POST['user'];
    $product = $_POST['product_id'];
    $p_price = $_POST['product_price'];
    $p_quantity=$_POST['quantity'];
    $p_color=$_POST['color'];
    $p_size=$_POST['size'];
    $nettotal=intval($p_price)*intval($p_quantity);
    echo $nettotal;
    echo'<script>alert(<?php echo $nettotal; ?>)</script>';
    $sql= "INSERT INTO cart (user_id,product_id,size_id,color_id,price,quantity,net_total,is_checked_out)VALUES ($user,$product,$p_size,$p_color,$p_price,$p_quantity,$nettotal,0)";
    $result=$conn->query($sql);
    if($result)
    echo'<script>alert("Product added to cart!")</script>';
    else
    echo'<script>alert("Product could not be added to cart!")</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="prostyle.css">
    <link rel="stylesheet" href="css/slick.css"/>
    <link href="stylecat.css" rel="stylesheet">
    <link rel="stylesheet" href="navstyle.css">
    <link rel="stylesheet"href="buttonstyle.css">
    <link href="style-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="productstyle.css" />
    <link rel="stylesheet" href="space-type-style.css" />
    <script src="https://unpkg.com/phosphor-icons"></script>
    <title>Product</title>
  </head>
  <body>
    <?php
      $sql="SELECT * from product where product_id='$product'";
      $result = $conn-> query($sql);
      if ($result-> num_rows > 0){
      while($row = $result-> fetch_assoc()){ 
    ?>
    <div class="popUP">
      <div class="gallery2">
        <div class="slideshow-container2">
          <!-- Full-width images -->
          <div class="mySlides2 fade">
            <img src="<?php echo $row['image1']?>" alt="test2"
            style="width:100%">
          </div>

          <div class="mySlides2 fade">
            <img src="<?php echo $row['image2']?>" alt="test2"
            style="width:100%">
          </div>

          <div class="mySlides2 fade">
            <img
              src="<?php echo $row['image3']?>"
              alt="test3"
              style="width: 100%"
            />
          </div>
      
          <a class="prev">&#10094;</a>
          <a class="next">&#10095;</a>
        </div>
        <i class="ph-x close-butt"></i>
      </div>
      <?php
              }
              }
          ?>
    </div>

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
      <section class="product">
        <?php
          $sql="SELECT * from product where product_id='$product'";
          $result = $conn-> query($sql);
          if ($result-> num_rows > 0){
          while($row = $result-> fetch_assoc()){ 
        ?>
        <div class="gallery">
          <div class="slideshow-container">
            <!-- Full-width images -->
            <div class="mySlides fade">
              <img src="<?php echo $row['image1']?>" alt="test2"
              style="width:100%">
            </div>

            <div class="mySlides fade">
              <img src="<?php echo $row['image2']?>" alt="test2"
              style="width:100%">
            </div>

            <div class="mySlides fade">
              <img
                src="<?php echo $row['image3']?>"
                alt="test3"
                style="width: 100%"
              />
            </div>
            <a class="prev">&#10094;</a>
            <a class="next">&#10095;</a>
          </div>
        </div>
        <div class="pictures">
          <div class="marB24 selected-pic">
            <img class="main-pic" src="<?php echo $row['image1']?>" alt="" />
          </div>
          <img
            class="thumbnail thumbnail1"
            src="<?php echo $row['image1']?>"
            alt=""
          />
          <img
            class="thumbnail thumbnail2"
            src="<?php echo $row['image2']?>"
            alt=""
          />
          <img
            class="thumbnail thumbnail3"
            src="<?php echo $row['image3']?>"
            alt=""
          />
        </div>
        <figure>
          <div class="description">
            <h1 class="bolder fs31 marT32 headerr">
              <?php echo $row['product_name']?>
            </h1>
            <p class="marT40 fs16 desc-text">
              <?php echo $row['product_desc']?>
            </p>
            <section class="marT32 pricing">
              <h1 class="bold fs20 price-off">₹ <?php echo $row['price']?></h1>
            </section>
          </div>
          </br></br>
              <form method="POST" class="box" action=" " enctype="multipart/form-data">
                <label for="Quantity">
                  Quantity: 
                </label>
                <input type="number"name="quantity" min="1" value="1"name="quantity" max="<?php echo $row['total_quantity']?>">
                <input type="hidden" name="product_id" value="<?php echo $product;?>">
                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                <?php
          }
        }
        ?>
                </br></br>
                <label for="Color">
                  Color: 
                </label>
                
                  <select class="custom-select col-xl-9 col-lg-8 col-md-8 col-sm-7" name="color"id="color">
                    <?php
                      $sql="SELECT * from color c, product_color_var pc where product_id=$product and pc.color_id=c.color_id";
                      $result = $conn-> query($sql);
                      if ($result-> num_rows > 0){
                      while($row = $result-> fetch_assoc()){
                      echo"<option value='". $row['color_id'] ."'>" .$row['color_name'] ."</option>";
                      }
                      }
                    ?>
                  </select>
                
                </br></br>
                <label for="Size">
                  Size: 
                </label>
                
                  <select class="custom-select col-xl-9 col-lg-8 col-md-8 col-sm-7" name="size"id="size">
                    <?php
                      $sql="SELECT * from sizes s, product_size_variation ps where product_id=$product and s.size_id=ps.size_id";
                      $result = $conn-> query($sql);
                      if ($result-> num_rows > 0){
                      while($row = $result-> fetch_assoc()){
                      echo"<option value='". $row['size_id'] ."'>" .$row['size_name'] ."</option>";
                      }
                      }
                    ?>
                  </select>
                </br></br>
              
                <?php $query=mysqli_query($conn,"select * from users where email='$email'");
                while($row=mysqli_fetch_array($query))
                {?>
                <input type="hidden" name="user" value="<?php echo $row['user_id'];?>">
                <?php } ?>             
                <button type="submit" value="add to cart" name="add_to_cart" class="add-to-card" data-bs-toggle="modal" data-bs-target="" style="padding:15px;padding-right:30px;"><span class="bold fs14 marL16 add-to-card-text">Add to Cart </span></button>
              </form>
        </figure>
      </section>
    </main>
   
    <!--<script src="product_script.js"></script>-->
  </body>
</html>





