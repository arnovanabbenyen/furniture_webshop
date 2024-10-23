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
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="logo">HENK</a>
        <a href="#">Eetkamerstoelen</a>
        <a href="#">Zitbanken</a>
        <a href="#">Fauteuils</a>
        <a href="#">Poefs</a>
    
    
    <form action="" method="get">
      <input placeholder="search" type="text" name="search">
    </form>
    
    <a href="login.php" class="logout" >Logout</a>
</nav>


    
</body>
</html>