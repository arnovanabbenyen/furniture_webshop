<?php
  $pathToSSL = __DIR__ . '/cacert.pem';
  $options = array(PDO::MYSQL_ATTR_SSL_CA => $pathToSSL);

  $host = 'studiohenkfurniture.mysql.database.azure.com';
  $db = 'henk';
  $user = 'Arno';
  $pass = '$2y$12$1D3KI6THZZzYSXw6SjFz6.OB/Hn/JbgK/rnIbsZKzKgPgxYJX21LK';
  $db = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $options);

  $users = $db->query('SELECT * FROM user');
  var_dump($users->fetchAll());


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php echo "Hello!"; ?>


    
</body>
</html>