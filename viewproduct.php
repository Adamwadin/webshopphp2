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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        <h1>one product</h1>
        <div>
            <?php
            $product = $dbContext->getProductById($id);
            echo "<h2>$product->title</h2>";
            echo "<p>$product->price</p>";
            echo "<p>$product->stockLevel</p>";
            echo "<a href='editproduct.php?id=$product->id'>Edit</a>";
            ?>



        </div>

</body>

</html>