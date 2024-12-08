<?php

include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Admin.php");
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Customer.php");
include_once(__DIR__ . "/classes/Product.php");
include_once(__DIR__ . "/classes/Order.php");

session_start();
    if($_SESSION['logged in'] != true){
        header('Location: login.php');
    }

$conn = Db::getConnection();
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

if ($category_id) {
    $statement = $conn->prepare('SELECT * FROM product WHERE category_id = :category_id');
    $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $statement = $conn->query('SELECT * FROM product');
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
}

$getUser = User::getUser($_SESSION['email']);
if($getUser['is_admin'] != 0){
    $user = new Admin();
}
else{
    $user = new Customer();
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Henks Products</title>
</head>
<body>

<?php include_once("nav.inc.php");?>

<div class="collection">
    <div class="add_product <?php if(!$user->canAddProduct()){echo 'hidden';}?>">
    <a href="new_product.php">+</a>
    </div>
    <?php foreach($products as $product): ?>
    <div class="collection_product">
        <a href="product.php?id=<?php echo $product['id']; ?>">
            <img src="<?php echo $product['image']; ?>" alt="">
            <div class="item_product">
                <p><?php echo $product['title']; ?></p>
                <p><?php echo $product['short_description']; ?></p>
                <p>Vanaf €<?php echo $product['price']; ?></p>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
    
</body>
</html>