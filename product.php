<?php

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

    <div>
        <img src="<?php echo $product['image']; ?>" alt="">
        <h1><?php echo ($product['title']); ?></h1>
        <p><?php echo ($product['description']); ?></p>
        <p>Price: €<?php echo ($product['price']); ?></p>
    </div>
    
</body>
</html>