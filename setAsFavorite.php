<?php
// Include or require necessary files
require_once ('Models/Database.php');
require_once ('Models/UserDatabase.php');
require_once ('Models/Category.php');
require_once ('Models/Product.php');


$dbContext = new DBContext();


// Function to add the product to favorites in the database
function setAsFavorite($productId, $userDatabase)
{
    // Retrieve user ID based on the current user (replace 'current_user' with actual username)
    $userId = $userDatabase->getAuth()->getUserId();

    // Check if user ID is valid
    if ($userId !== null) {
        // Prepare and execute SQL statement to insert the product into favorites
        $pdo = $userDatabase->getPDO();
        $stmt = $pdo->prepare("INSERT INTO favorites (userId, productId) VALUES (?, ?)");
        $stmt->execute([$userId, $productId]);

        // Optionally, you can check if the insertion was successful and handle any errors
        if ($stmt->rowCount() > 0) {
            // Product successfully added to favorites
            return true;
        } else {
            // Error occurred while adding the product to favorites
            return false;
        }
    } else {
        // Unable to retrieve user ID
        return false;
    }
}

// Check if the request method is POST and productId is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["productId"])) {
    // Retrieve the productId from the POST data
    $productId = $_POST["productId"];

    // Call setAsFavorite function to add the product to favorites
    if (setAsFavorite($productId, $dbContext->userDatabase)) {
        // Redirect back to the page where the form was submitted
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        // Handle error
        http_response_code(500);
        echo "Error: Unable to add the product to favorites.";
    }
} else {
    // Handle invalid request
    http_response_code(400);
    echo "Invalid request.";
}
?>