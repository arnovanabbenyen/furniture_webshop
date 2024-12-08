<?php

include_once("Db.php");

class Order{
    private $id;
    private $user_id;
    private $product_id;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of user_id
     */ 
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */ 
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

     /**
     * Get the value of product_id
     */ 
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */ 
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function save(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO `order` (user_id) VALUES (:user_id)");
        $statement->bindValue(":user_id", $this->user_id);
        $statement->execute();
        return $conn->lastInsertId();

    }

    public static function getOrders($user_id){
        $conn = Db::getConnection();
        $statement = $conn->prepare('SELECT * FROM `order` WHERE user_id = :user_id');
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOrderProducts($order_id) {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT product_id FROM order_products WHERE order_id = :order_id");
        $statement->bindValue(":order_id", $order_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function addProductOrder($order_id, $product_id) {
        $conn = Db::getConnection();
        $statement = $conn->prepare('INSERT INTO order_products (order_id, product_id) VALUES (:order_id, :product_id)');
        $statement->bindValue(':order_id', $order_id);
        $statement->bindValue(':product_id', $product_id);
        $statement->execute();
    }
   
}