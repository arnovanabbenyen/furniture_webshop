<?php

    session_start();
    if($_SESSION['logged in'] != true){
        header('Location: login.php');
    }
    include_once("classes/Product.php");
    include_once("classes/Admin.php");
    include_once("classes/Db.php");
    include_once("classes/User.php");
    $getUser = User::getUser($_SESSION['email']);
        if($getUser['is_admin'] != 0){
        $user = new Admin();
    }
    else{
        $user = new Customer();
    }   
    if(!empty($_POST)){
        $product = new Product();
        $product->setTitle($_POST['title']);
        $product->setShort_description($_POST['short_description']);
        $product->setLong_description($_POST['long_description']);
        $product->setPrice($_POST['price']);
        $product->setCategory_id($_POST['category_id']);
        $product->save();
        header('Location: products.php');
    }


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Add Product</title>
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
            <div class="add_image">
                <p>+</p>
            </div>
            <form class="add_product_form" action="" method="post" enctype="multipart/form-data">
                <h1>Add New Product</h1>
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
                
                <label for="short_description">Short Description:</label>
                <textarea name="short_description" id="short_description" required></textarea>
                
                <label for="long_description">Long Description:</label>
                <textarea name="long_description" id="long_description" required></textarea>

                <label for="image">Image:</label>
                <input type="url" name="image" id="image" required>
                
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" required>
                
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" required>
                    <option value="1">Dining Room Chairs</option>
                    <option value="2">Sofas</option>
                    <option value="3">Armchairs</option>
                    <option value="4">Poufs</option>
                </select>
                <div class="action">
                    <button type="submit">Add Product</button>
                </div>
                
        
                
            </form>
        </div>
    </div>
</main>
    
</body>
</html>