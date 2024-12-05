<?php

  session_start();
    if($_SESSION['logged in'] != true){
      header('Location: login.php');
  }

    if (!isset($_GET['id'])) {
        exit("404");
    }
    
    include_once(__DIR__ . "/classes/Db.php");
    include_once(__DIR__ . "/classes/Admin.php");
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/Customer.php");
    include_once(__DIR__ . "/classes/Product.php");

    
    // Establish a connection to the database
    $conn = Db::getConnection();
    
    // Fetch product data from the database based on the provided id
    $id = $_GET['id'];
    $statement = $conn->prepare('SELECT * FROM product WHERE id = :id');
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        exit("Product not found");
    }

    $getUser = User::getUser($_SESSION['email']);
      if($getUser['is_admin'] != 0){
      $user = new Admin();
    }
    else{
      $user = new Customer();
    }

    if(!empty($_POST)){
        $product = new Product();
        $product->setId($_GET['id']);
        $product->delete();
        header('Location: products.php');
    }

  
    


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Document</title>
</head>
<body>

    <?php include_once("nav.inc.php");?>

    <main>
    <div class="card">
      <div class="card__title">
        <div class="icon">
          <a href="products.php">←</a>
        </div>
      </div>
      <div class="card__body">
          <div class="image">
            <img src="<?php echo $product['image']; ?>" alt="">
            </div>
          <div class="description">
            <h1><?php echo $product['title'] . ' ' . $product['short_description']; ?></h1>            <p><?php echo ($product['long_description']); ?></p>
            <p>Price: €<?php echo ($product['price']); ?></p>
            <div class="card__footer">
              <form action="" method="POST" class="delete_update_btn">
                <div class="action <?php if($user->canDeleteProduct()){echo 'hidden';}?>">
                    <button type="button">Add to cart</button>
                </div>
                <div class="action <?php if(!$user->canDeleteProduct()){echo 'hidden';}?>">
                  <button type="submit" name="delete" value="<?php echo $product['id'];?>" >Delete product</button>
                </div>
                <div class="action <?php if(!$user->canUpdateProduct()){echo 'hidden';}?>">
                    <a href="update_product.php?id=<?php echo $product['id']; ?>">Update product</a>
                </div>
              </form>
            </div>
          </div>
      </div>
      
    </div>
  </main>
    
</body>
</html>