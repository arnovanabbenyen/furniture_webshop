<?php

    class Db{
        private static $conn = null;

        public static function getConnection(){
            //Db::getConnection();
            if(self::$conn == null){
                $pathToSSL = __DIR__ . '/cacert.pem';
                $options = array(PDO::MYSQL_ATTR_SSL_CA => $pathToSSL);

                $host = 'studiohenkfurniture.mysql.database.azure.com';
                $db = 'henk';
                $user = 'Arno';
                $pass = '$2y$12$1D3KI6THZZzYSXw6SjFz6.OB/Hn/JbgK/rnIbsZKzKgPgxYJX21LK';
                $db = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $options);
                self::$conn = $db;
                return self::$conn;
            }
            else{
                return $conn;
            }
        }
    }

?>