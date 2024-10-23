<?php

    class Db{
        private static $conn = null;

        public static function getConnection(){
            //Db::getConnection();
            if(self::$conn == null){
                self::$conn = new PDO('mysql:host=127.0.0.1;dbname=webshop', 'root', '');
                return self::$conn;
            }
            else{
                return $conn;
            }
        }
    }

?>