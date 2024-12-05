<?php

class Product {
    private $title;
    private $short_description;
    private $long_description;
    private $price;
    private $category_id;

    

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    

    /**
     * Get the value of short_description
     */ 
    public function getShort_description()
    {
        return $this->short_description;
    }

    /**
     * Set the value of short_description
     *
     * @return  self
     */ 
    public function setShort_description($short_description)
    {
        $this->short_description = $short_description;

        return $this;
    }

    

    /**
     * Get the value of long_description
     */ 
    public function getLong_description()
    {
        return $this->long_description;
    }

    /**
     * Set the value of long_description
     *
     * @return  self
     */ 
    public function setLong_description($long_description)
    {
        $this->long_description = $long_description;

        return $this;
    }

    

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    

    /**
     * Get the value of category_id
     */ 
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */ 
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function save(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("INSERT INTO product (title, short_description, long_description, price, category_id) VALUES (:title, :short_description, :long_description, :price, :category_id)");
        $statement->bindValue(':title', $this->title);
        $statement->bindValue(':short_description', $this->short_description);
        $statement->bindValue(':long_description', $this->long_description);
        $statement->bindValue(':price', $this->price);
        $statement->bindValue(':category_id', $this->category_id);
        return $statement->execute();
    }

}