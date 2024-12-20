<?php
  
  session_start();
  if($_SESSION['logged in'] !== true){
  header('Location: login.php');
  }
  

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Studio-henk-furniture</title>
</head>
<body>

<?php include_once("nav.inc.php"); ?>

<main>

<section class="promo_video">
  <div class="video">
      <video muted loop playsinline autoplay src="https://assets.studio-henk.nl/assets/Images/2024-products/aw24/StudioHenk_AW24_brandvideo1_1920x1080_website.mp4" type="video/mp4"></video>
  </div>
  <div class="video_overlay">
    <div class="video_content">
      <h1>Studio Henk</h1>
      <p>Discover our new collection</p>
      <form action="products.php" method="GET">
        <input type="search" name="search" placeholder="Search for products...">
      </form>
    </div>
  </div>

</section>

<section class="our_products">
  <div class="our_products_header">
    <h2>Our Products</h2>
  </div>

  <div class="products">
    <div class="product">
      <a href="products.php?category_id=1">
        <img  src="Images/product_drc.webp" alt="">
        <div class="item__content">
          <p class="item__title">Dining room chairs</p>
        </div>
      </a>
    </div>

    <div class="product">
      <a href="products.php?category_id=2">
        <img  src="Images/product_sofa.jpg" alt="">
        <div class="item__content">
          <p class="item__title">Sofas</p>
        </div>
      </a>
    </div>

    <div class="product">
      <a href="products.php?category_id=3">
        <img  src="Images/product_armchair.jpg" alt="">
        <div class="item__content">
          <p class="item__title">Armchairs</p>
        </div>
      </a>
    </div>

    <div class="product">
      <a href="products.php?category_id=4">
        <img  src="Images/product_pouf.jpg" alt="">
        <div class="item__content">
          <p class="item__title">Poufs</p>
        </div>
      </a>
    </div>

  </div>

  

</section>
  

</main>


    
</body>
</html>