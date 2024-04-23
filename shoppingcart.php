<?php

// Path: shoppingcart.php
require_once "Models/Product.php";
require_once "Models/Database.php";

$dbContext = new DBContext();
$q = $_GET['q'] ?? "";
$c = $_GET['c'] ?? "";
$id = $_GET['id'] ?? "";
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;

?>

<div>
    <h1>Shopping Cart</h1>
    <div>
        <?php
        $product = $dbContext->getProductById($id);
        echo "<h2>$product->title</h2>";
        echo "<p>$product->price</p>";
        echo "<p>$product->stockLevel</p>";
        echo "<a href='editproduct.php?id=$product->id'>Edit</a>";
        ?>
    </div>
</div>
<?php
$cart = $dbContext->getCart();
foreach ($cart as $product) {
    echo "<div>";
    echo "<h2>$product->title</h2>";
    echo "<p>$product->price</p>";
    echo "<p>$product->stockLevel</p>";
    echo "<a href='editproduct.php?id=$product->id'>Edit</a>";
    echo "</div>";
}
?>
<?php
