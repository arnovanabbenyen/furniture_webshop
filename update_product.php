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


$conn = Db::getConnection();
$id = $_GET['id'];
$statement = $conn->prepare('SELECT * FROM product WHERE id = :id');
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);


$getUser = User::getUser($_SESSION['email']);
if($getUser['is_admin'] != 0){
    $user = new Admin();
}
else{
    $user = new Customer();
}


if(!empty($_POST)){
    $product = new Product();
    $product->setId($id);
    $product->setTitle($_POST['title']);
    $product->setShort_description($_POST['short_description']);
    $product->setLong_description($_POST['long_description']);
    $product->setPrice($_POST['price']);
    $product->setCategory_id($_POST['category_id']);
    $product->update();
    header('Location: product.php?id=' . $id);
}






?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Update <?php echo htmlspecialchars($product['title']); ?></title>  </head>
</head>
<body>

<?php include_once("nav.inc.php");?>
<main>
    <div class="card">
        <div class="card__title">
            <div class="icon">
                <a href="product.php?id=<?php echo $id; ?>">←</a>
            </div>
        </div>
        <div class="card__body">
            <div class="image">
                <img src="<?php echo $product['image'] ?>"alt="">
            </div>
            <form class="add_product_form" action="" method="post" enctype="multipart/form-data">
                <h1>Update Product</h1>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $product['title']; ?>" required>
                
                <label for="short_description">Short Description:</label>
                <input type="text" id="short_description" name="short_description" value="<?php echo $product['short_description']; ?>" required>
                
                <label for="long_description">Long Description:</label>
                <textarea name="long_description" id="long_description" required><?php echo $product['long_description']; ?></textarea>

                <label for="image">Image:</label>
                <input type="url" name="image" id="image" required>
                
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                
                <label for="category_id">Category:</label>
                    <select name="category_id" id="category_id" required>
                        <option value="1" <?php if ($product['category_id'] == 1) echo 'selected'; ?>>Dining Room Chairs</option>
                        <option value="2" <?php if ($product['category_id'] == 2) echo 'selected'; ?>>Sofas</option>
                        <option value="3" <?php if ($product['category_id'] == 3) echo 'selected'; ?>>Armchairs</option>
                        <option value="4" <?php if ($product['category_id'] == 4) echo 'selected'; ?>>Poufs</option>
                    </select>
                    <div class="action">
                        <button type="submit">Update Product</button>
                    </div>
            </form>
        </div>
    </div>
</main>
    
</body>
</html>