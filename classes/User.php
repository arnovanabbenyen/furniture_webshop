<?php

    include_once("Db.php");

    class User{
        protected $id;
        protected $first_name;
        protected $last_name;
        protected $email;
        protected $password;
        protected $digital_currency;


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
         * Get the value of first_name
         */ 
        public function getFirst_name()
        {
                return $this->first_name;
        }

        /**
         * Set the value of first_name
         *
         * @return  self
         */ 
        public function setFirst_name($first_name)
        {

            if(empty($first_name)){
                throw new Exception("Firstname cannot be empty");
            }
                $this->first_name = $first_name;

                return $this;
        }

        /**
         * Get the value of last_name
         */ 
        public function getLast_name()
        {
                return $this->last_name;
        }

        /**
         * Set the value of last_name
         *
         * @return  self
         */ 
        public function setLast_name($last_name)
        {       
                if(empty($last_name)){
                    throw new Exception("Lastname cannot be empty");
                }
                $this->last_name = $last_name;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {       if(empty($email)){
                    throw new Exception("Email cannot be empty");
                }
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {       if(empty($password)){
                    throw new Exception("Password cannot be empty");
                }
                $options = [
                    'cost' => 12,
                ];
                $hash= password_hash($password, PASSWORD_DEFAULT, $options);
                $this->password = $hash;

                return $this;
        }

        /**
         * Get the value of digital_currency
         */ 
        public function getDigital_currency()
        {
                return $this->digital_currency;
        }

        /**
         * Set the value of digital_currency
         *
         * @return  self
         */ 
        public function setDigital_currency()
        {
                $this->digital_currency;

                return $this;
        }

        public function save(){
            //PDO connection
            $conn = Db::getConnection();
            $statement = $conn->prepare('INSERT INTO user (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)');
            $statement->bindValue(':first_name', $this->first_name);
            $statement->bindValue(':last_name', $this->last_name);
            $statement->bindValue(':email', $this->email);
            $statement->bindValue(':password', $this->password);
            return $statement->execute();
        }

        public static function getUser($email,){
            $conn = Db::getConnection();
            $statement = $conn->prepare('SELECT * FROM user WHERE email = :email');
            $statement->bindValue(':email', $email);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }

        public static function getAll(){
            $conn = Db::getConnection();
            $statement = $conn->query('SELECT * FROM user');
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }

        public function update() {
            $conn = Db::getConnection();
            $statement = $conn->prepare('UPDATE user SET first_name = :first_name, last_name = :last_name, email = :email, password = :password WHERE email = :email');
            $statement->bindValue(':first_name', $this->first_name);
            $statement->bindValue(':last_name', $this->last_name);
            $statement->bindValue(':email', $this->email);
            $statement->bindValue(':password', $this->password);
            return $statement->execute();
        }
    
        // Check if email exists
        public static function emailExists($email) {
            $conn = Db::getConnection();
            $statement = $conn->prepare('SELECT COUNT(*) FROM user WHERE email = :email');
            $statement->bindValue(':email', $email);
            $statement->execute();
            return $statement->fetchColumn() > 0;
        }

        public static function updateDigitalCurrency($new_balance){ 
            $conn = Db::getConnection();
            $statement = $conn->prepare("UPDATE user SET digital_currency = :digital_currency WHERE email = :email");
            $statement->bindValue(":digital_currency", $new_balance);
            $statement->bindValue(":email", $_SESSION['email']);
            $statement->execute();
        }
    }