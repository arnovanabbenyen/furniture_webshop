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
  include_once(__DIR__ . "/classes/Review.php");

  $conn = Db::getConnection();
  $id = $_GET['id'];
  $statement = $conn->prepare('SELECT * FROM product WHERE id = :id');
  $statement->bindValue(':id', $id, PDO::PARAM_INT);
  $statement->execute();
  $product = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $conn->prepare('SELECT * FROM review WHERE product_id = :id');
  $statement->bindValue(':id', $id, PDO::PARAM_INT);
  $statement->execute();
  $reviews = $statement->fetchAll(PDO::FETCH_ASSOC);

  $product_id = $product['id'];
  $product_price = $product['price'];

  if (!$product) {
    exit("Product not found");
  }

  $getUser = User::getUser($_SESSION['email']);
  if($getUser['is_admin'] != 0){
    $user = new Admin();
  }
  else{
    $user = new Customer();
    $user_id = $getUser['id'];
    $_SESSION['digital_currency'] = $getUser['digital_currency'];  // Voeg digitale valuta toe aan de sessie
  }
    
  if(!empty($_POST['delete'])){
      $product = new Product();
      $product->setId($_GET['id']);
      $product->delete();
      header('Location: products.php');
  }
  
  $review = new Review();
  $reviews = $review->getAllReviews($id);
  
  if (isset($_POST['buy'])) {
      // Controleer of de gebruiker genoeg digitale valuta heeft
      if ($_SESSION['digital_currency'] >= $product['price']) {
          // Verminder het aantal digitale valuta van de gebruiker
          $new_balance = $_SESSION['digital_currency'] - $product['price'];
          $user->setDigital_currency();
          $user->updateDigitalCurrency($new_balance);  // Werk de digitale valuta bij in de database

          // Insert order details into the orders table
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO `order` (user_id, product_id) VALUES (:user_id, :product_id)");
        $statement->bindValue(":user_id", $user_id);
        $statement->bindValue(":product_id", $product['id']);
        $statement->execute();
  
          // Update the digital currency in the session
          $_SESSION['digital_currency'] = $new_balance;
  
          // Toon succesbericht
          $message = "Thanks for purchasing! Your new balance is €" . number_format($new_balance, 2) . ".";
        } else {
            $message = "You don't have enough digital currency to purchase this product.";
        }
  }
  ?>
  
  <!DOCTYPE html>
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
            <h1><?php echo $product['title'] . ' ' . $product['short_description']; ?></h1>
            <p><?php echo ($product['long_description']); ?></p>
            <p>Price: €<?php echo ($product['price']); ?></p>
             <div class="<?php if(!$user->canBuy()){echo 'hidden';}?>">
            <p>Your Digital Currency: €<?php echo number_format($_SESSION['digital_currency'], 2); ?></p>
            <p class="<?php if ($_SESSION['digital_currency'] >= $product['price']) { echo ''; } else { echo 'hidden'; } ?>">Remaining after purchase: €<?php echo number_format($_SESSION['digital_currency'] - $product['price'], 2); ?></p>
            </div>
            <?php if (isset($message)): ?>
              <div class="notification">
                <p><?php echo $message; ?></p>
              </div>
            <?php endif; ?>
            <div class="card__footer">
              <?php if ($_SESSION['digital_currency'] >= $product['price']): ?>
                <form action="" method="POST">
                  <div class="action <?php if($user->canDeleteProduct()){echo 'hidden';}?>">
                    <button type="submit" name="buy">Buy product</button>
                  </div>
                </form>
              <?php else: ?> 
                <div class="action <?php if($user->canDeleteProduct()){echo 'hidden';}?> ">
                  <button type="button" disabled>Not enough digital currency</button>
                </div>
              <?php endif; ?>
              <form action="" method="POST" class="delete_update_btn">
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
  
    <section>
      <div class="reviews">
        <h2>Leave a Review</h2>
        <div class="review-form">
          <input type="hidden" name="product_id" value="<?php echo $product_id['id']; ?>">
          <span class="rating">
            <label for="rating">Give a rating:</label>
            <select name="custom_rating" id="custom_rating">
              <option value="0.0">0</option>
              <option value="1.0">1</option>
              <option value="2.0">2</option>
              <option value="3.0">3</option>
              <option value="4.0">4</option>
              <option value="5.0"  selected="selected">5</option>
            </select>
          </span>
          <label for="comment">Write a comment:</label>
          <textarea name="custom_review" id="custom_review" placeholder="Write a comment here"></textarea>
          <input type="submit" value="comment" class="btn1" id="addReviewBtn" data-product_id="<?php echo $product_id['id']; ?>" data-user_id="<?php echo $user_id['id']; ?>">
        </div>
      </div>
    </section>
  
    <script src="js/review.js"></script>
  </body>
  </html>