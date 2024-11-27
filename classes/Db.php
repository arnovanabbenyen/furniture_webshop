<?php

class Db {
    private static $conn = null;

    public static function getConnection() {
        echo "1\n";

        if (self::$conn === null) {
            echo "2\n";

            $pathToSSL = __DIR__ . '/cacert.pem';

            // Ensure the certificate file exists
            if (!file_exists($pathToSSL)) {
                die("SSL certificate not found at: $pathToSSL");
            }

            $options = array(
                PDO::MYSQL_ATTR_SSL_CA => $pathToSSL,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exception mode
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Fetch as associative array
            );

            $host = 'studiohenkfurniture.mysql.database.azure.com';
            $dbname = 'henk';
            $user = 'Arno';
            $pass = '$2y$12$1D3KI6THZZzYSXw6SjFz6.OB/Hn/JbgK/rnIbsZKzKgPgxYJX21LK'; // Replace with the actual password

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, $options);
                echo "Connection successful.\n";

                // Test query
                $query = $pdo->query('SELECT * FROM user');
                $result = $query->fetchAll();
                var_dump($result);

                self::$conn = $pdo; // Assign PDO instance to static property
                return self::$conn;

            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        } else {
            return self::$conn;
        }
    }
}

// Test the connection
Db::getConnection();

?>
