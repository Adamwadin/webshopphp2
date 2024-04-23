<?php

// Path: viewCategory.php
require_once "Models/Product.php";
require_once "Models/Database.php";



$dbContext = new DBContext();
$q = $_GET['q'] ?? "";
$c = $_GET['c'] ?? "";
$id = $_GET['id'] ?? "";
$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;

?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Products</h1>
            <div class="row">
                <?php
                if ($categoryId) {
                    $products = $dbContext->getProductsByCategory($categoryId);
                } else {
                    $products = $dbContext->getAllProducts();
                }
                foreach ($products as $product) {
                    echo "<div class='col-3'>";
                    echo "<h2>$product->title</h2>";
                    echo "<p>$product->price</p>";
                    echo "<p>$product->stockLevel</p>";
                    echo "<a href='viewproduct.php?id=$product->id'>View</a>";
                    echo "</div>";
                }

                ?>
            </div>
        </div>
    </div>
</div>