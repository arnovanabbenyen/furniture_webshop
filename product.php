<?php

  session_start();
    if($_SESSION['logged in'] != true){
    header('Location: login.php');
  }

    if (!isset($_GET['id'])) {
        exit("404");
    }
    
    include_once(__DIR__ . "/classes/Db.php");
    
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
            <h1><?php echo ($product['title']), ($product['short_description']); ?></h1>
            <p><?php echo ($product['long_description']); ?></p>
            <p>Price: €<?php echo ($product['price']); ?></p>
            <div class="card__footer">
                <div class="action">
                    <button type="button">Add to cart</button>
                </div>
            </div>
          </div>
      </div>
      
    </div>
  </main>

  <section>
  <div class="reviews">
        <h2>Reviews</h2>
        <div id="reviews-list">
            <!-- Existing reviews will be loaded here -->
        </div>
        <h3>Leave a Review</h3>
        <form id="review-form">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <label for="rating">Rating:</label>
            <select name="rating" id="rating">
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" required></textarea>
            <button type="submit">Submit Review</button>
        </form>
    </div>
  </section>
    
</body>
</html>