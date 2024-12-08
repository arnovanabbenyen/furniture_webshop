<?php
// Controleer of de gebruiker is ingelogd
if ($_SESSION['logged in'] != true) {
    header('Location: login.php');
    exit;
}

// Haal de digitale valuta van de gebruiker uit de sessie
$digital_currency = isset($_SESSION['digital_currency']) ? $_SESSION['digital_currency'] : 0;
?>

<nav class="navbar">
    <a href="index.php" class="logo">HENK</a>
    <a href="products.php">All products</a>
    <a href="products.php?category_id=1">Dining room chairs</a>
    <a href="products.php?category_id=2">Sofas</a>
    <a href="products.php?category_id=3">Armchairs</a>
    <a href="products.php?category_id=4">Poufs</a>
    
    <div class="dropdown">
        <a href="#" class="logout">Logout</a>
        <div class="dropdown-content">
            <a href="profile.php">Profile</a>
            <a href="login.php">Logout</a>
            <!-- Voeg de digitale valuta van de gebruiker toe aan de dropdown -->
            <p>Digital Currency: €<?php echo number_format($digital_currency, 2); ?></p>
        </div>
    </div>
</nav>
