<?php
require_once ("Models/Database.php");
$id = $_GET['id'] ?? "";


$dbContext = new DBContext();
//Köra en insert into shoppingcartitem
$antal = $dbContext->addToCart($id);

// $
echo json_encode($antal);

?>
// Compare this snippet from login.php: