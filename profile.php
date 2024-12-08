<?php
include_once(__DIR__ . "/classes/User.php");
include_once(__DIR__ . "/classes/Db.php");
include_once(__DIR__ . "/classes/Product.php");
include_once(__DIR__ . "/classes/Order.php");

session_start();

// Zorg ervoor dat de gebruiker is ingelogd
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Haal de huidige gegevens van de gebruiker op
$user = User::getUser($_SESSION['email']);
$orders = Order::getOrders($user['id']);

// Fetch orders for the user
$conn = Db::getConnection();
$statement = $conn->prepare("SELECT * FROM `order` WHERE user_id = :user_id");
$statement->bindValue(":user_id", $user['id']);
$statement->execute();
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);


if (!$user) {
    // Als de gebruiker niet gevonden wordt, stuur de gebruiker terug naar de loginpagina
    header("Location: login.php");
    exit();
}

// Verwerk het formulier als er gegevens zijn verzonden
if (!empty($_POST)) {
    try {
        // Maak een nieuwe User instantie om de nieuwe gegevens in te stellen
        $updatedUser = new User();
        $updatedUser->setId($user['id']);
        $updatedUser->setFirst_name($_POST['first_name']);
        $updatedUser->setLast_name($_POST['last_name']);
        $updatedUser->setEmail($_POST['email']);

        // Controleer of het wachtwoord is ingevuld en wijzig het alleen als dat zo is
        if (!empty($_POST['password'])) {
            $updatedUser->setPassword($_POST['password']);
        } else {
            // Zet het oude wachtwoord als het niet gewijzigd is
            $updatedUser->setPassword($user['password']);
        }

        // Controleer of het e-mailadres al bestaat
        if (User::emailExists($_POST['email']) && $_POST['email'] !== $user['email']) {
            throw new Exception("Dit e-mailadres is al in gebruik. Kies een ander e-mailadres.");
        }

        // Probeer de gebruiker bij te werken
        if ($updatedUser->update()) {
            header("Location: index.php");
            echo "<p class='success-message'>Profiel succesvol bijgewerkt!</p>";
        } else {
            echo "<p class='error-message'>Er is een fout opgetreden bij het bijwerken van het profiel.</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error-message'>Er is een fout opgetreden: " . $e->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Profiel bijwerken</title>
</head>
<body>

<?php include_once("nav.inc.php"); ?>

<div class="container profile-container">
    <h2 class="profile-header">Profiel bijwerken</h2>
    <form action="profile.php" method="post" class="profile-form">
        <label for="first_name" class="profile-label">Voornaam:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" class="profile-input" required>
        
        <label for="last_name" class="profile-label">Achternaam:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" class="profile-input" required>
        
        <label for="email" class="profile-label">E-mail:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="profile-input" required>
        
        <label for="password" class="profile-label">Wachtwoord</label>
        <input type="password" id="password" name="password" class="profile-input" required>
        
        <div class="action">
            <button type="submit" value="Bijwerken">Update</button>
        </div>
    </form>
</div>

<section class="user_orders">
            <h2>Your orders</h2>
            <?php foreach($orders as $order): ?>
                    <article>
                    <?php 
                        $order_products = Order::getOrderProducts($order['id']);
                        echo "<div class='order'>";
                        echo "<p>Order: #".$order['id']."</p>";
                        echo "<p>Order date: ".date("d-m-Y", strtotime($order['created_at']))."</p>";
                        echo "<p>Status: ".$order['status']."</p>";
                        echo "</div>";
                        echo "<div class='products'>";
                        foreach($order_products as $product){
                            $product_id = $product['product_id'];
                            $product = Product::getProductById($product_id);
                            echo "<div class='product'>";
                            echo "<div class='order_image_holder'><img src='".$product['image']."' alt='".$product['title']."'></div>";
                            echo "<p>".$product['title']."</p>";
                            echo "</div>";
                        }
                    ?>
                    </article>
                <?php endforeach;?>
        </section>
    
</body>
</html