<?php

include_once("Db.php");

    class Review {

        private $id;
        private $comment;
        private $rating;
        private $created_at;
        private $product_id;
        private $user_id;


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
         * Get the value of comment
         */ 
        public function getComment()
        {
                return $this->comment;
        }

        /**
         * Set the value of comment
         *
         * @return  self
         */ 
        public function setComment($comment)
        {
                $this->comment = $comment;

                return $this;
        }

        /**
         * Get the value of rating
         */ 
        public function getRating()
        {
                return $this->rating;
        }

        /**
         * Set the value of rating
         *
         * @return  self
         */ 
        public function setRating($rating)
        {
                $this->rating = $rating;

                return $this;
        }

        /**
         * Get the value of created_at
         */ 
        public function getCreated_at()
        {
                return $this->created_at;
        }

        /**
         * Set the value of created_at
         *
         * @return  self
         */ 
        public function setCreated_at($created_at)
        {
                $this->created_at = $created_at;

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

        public function save(){
            $conn = Db::getConnection();
            $statement = $conn->prepare('INSERT INTO review (comment, rating, created_at, product_id, user_id) VALUES (:comment, :rating, :created_at, :product_id, :user_id)');
            $statement->bindValue(':comment', $this->comment);
            $statement->bindValue(':rating', $this->rating);
            $statement->bindValue(':created_at', $this->created_at);
            $statement->bindValue(':product_id', $this->product_id);
            $statement->bindValue(':user_id', $this->user_id);
            return $statement->execute();
            
        }

        public static function getAllReviews(){
            $conn = Db::getConnection();
            $statement = $conn->query('SELECT * FROM review');
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
    }
