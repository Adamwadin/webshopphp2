<?php
// include --  OK även om filen inte finns
//include_once("Models/Products.php");
require_once ("Models/Database.php");

$dbContext = new DBContext();
$q = $_GET['q'] ?? "";
$c = $_GET['c'] ?? "";
$id = $_GET['id'] ?? "";
$favorite = $_GET['favorite'] ?? "";
$sortOrder = $_GET['sortOrder'] ?? "asc";
$customerId = $_GET['customerId'] ?? "";
$cartCount = $dbContext->getCartCount($customerId);











// Now $cartCount contains the count of items in the shopping cart for the specified customer




if ($sortOrder == "asc") {
    $sortOrder = "asc";
} else {
    $sortOrder = "desc";
}

$sortCol = $_GET['sortCol'] ?? "title";
if ($sortCol == "title") {
    $sortCol = "title";
} else if ($sortCol == "categoryId") {
    $sortCol = "categoryId";
} else if ($sortCol == "price") {
    $sortCol = "price";
} else if ($sortCol == "stockLevel") {
    $sortCol = "stockLevel";
}
if ($sortCol == "favorite") {
    $sortCol = "favorite";
}

$categoryId = $_GET['categoryId'] ?? "";
$pageNo = $_GET['pageNo'] ?? "1";
$pageSize = $_GET['pageSize'] ?? "20";






$categoryId = isset($_GET['categoryId']) ? $_GET['categoryId'] : null;



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Shop Homepage - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/css/styles.css" rel="stylesheet" />

</head>
<script>
    function addToCart(id) {
        fetch(`getcart.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("antal").innerHTML = data;
            });
    }






</script>

<body>

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">SuperShoppen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Categorier</a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <?php
                            foreach ($dbContext->getAllCategories() as $category) {
                                echo "<li><a class='dropdown-item' href='viewCategory.php?categoryId=$category->id'>$category->title</a></li> ";
                            }



                            ?>



                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Create account</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><?php if ($dbContext->getUsersDatabase()->getAuth()->isLoggedIn()) {
                        echo "Logout";
                        ?>
                            </a>
                        </li>

                        <li class="nav-item"> Logged in as:
                            <?php echo $dbContext->getUsersDatabase()->getAuth()->getUsername() ?>
                        </li>

                        <?php
                    } else {
                        echo "<li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li> ";

                    } ?></li>


                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill"
                            id="antal"><?php echo $cartCount ?></span>
                    </button>

                </form>

            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <?php
                $hour = date('h');
                if ($hour >= 9) {
                    ?>
                    <h1 class="display-4 fw-bolder">Super shoppen</h1>
                    <?php
                }
                ?>
                <p class="lead fw-normal text-white-50 mb-0">Handla massa onödigt hos oss!</p>
            </div>
        </div>
    </header>
    <!-- Section-->

    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">


            <h2 class="fw-bolder"> Top 10 favourite products</h2>


            <table class="table">
                <thead>
                    <tr>
                        <th>Title


                        </th>



                        <th>Category

                        </th>
                        <th>Price

                        </th>
                        <th>Stock level

                        <th>popularity

                        </th>



                    </tr>
                </thead>




                <?php
                $sortCol = "title";
                $sortOrder = "asc";
                $pageNo = 1;
                $pageSize = 15;





                if (isset($_GET['pageNo'])) {
                    $pageNo = $_GET['pageNo'];
                }
                if (isset($_GET['pageSize'])) {
                    $pageSize = $_GET['pageSize'];
                }


                if (isset($_GET['sortCol'])) {
                    $sortCol = $_GET['sortCol'];
                }
                if (isset($_GET['sortOrder'])) {
                    $sortOrder = $_GET['sortOrder'];
                }

                if (
                    isset($_GET['categoryId'])
                ) {
                    $categoryId = $_GET['categoryId'];
                }
                if (
                    isset($_GET['favorite'])
                ) {
                    $favorite = $_GET['favorite'];
                }



                foreach ($dbContext->getPopularProducts($limit = 10) as $product) {
                    echo "<tr>";
                    echo "<td>$product->title</td>";
                    echo "<td>$product->categoryId</td>";
                    echo "<td>$product->price</td>";
                    echo "<td>$product->stockLevel</td>";
                    if ($product->favorite > 0) {
                        echo "<td><strong>$product->favorite</strong></td>";
                    } else {
                        echo "<td>$product->favorite</td>";
                    }
                    echo "<td><a href='viewproduct.php?id=$product->id'>EDIT</a></td>";
                    echo "</form></td>";
                    echo "</tr>";
                }









                ?>





            </table>



            <table class="table">
                <thead>
                    <tr>
                        <th>Title

                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=title&sortOrder=asc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">ASC</a>
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=title&sortOrder=desc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">DESC</a>
                        </th>



                        <th>Category
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=categoryId&sortOrder=asc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">ASC</a>
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=categoryId&sortOrder=desc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">DESC</a>
                        </th>
                        <th>Price
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=price&sortOrder=asc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">ASC</a>
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=price&sortOrder=desc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">DESC</a>
                        </th>
                        <th>Stock level
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=stockLevel&sortOrder=asc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">ASC</a>
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=stockLevel&sortOrder=desc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">DESC</a>
                        </th>
                        <th>popularity
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=favorite&sortOrder=asc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">ASC</a>
                            <a
                                href="index.php?<?php echo $q ? "q=$q&" : "" ?>&sortCol=favorite&sortOrder=desc&pageNo=<?php echo $pageNo ?>&pageSize=<?php echo $pageSize ?>">DESC</a>
                        </th>



                    </tr>
                </thead>
                <form method="GET">
                    <input type="text" name="q" value="<?php echo $q; ?>">

                    <input type="hidden" name="sortCol" value="<?php echo $sortCol; ?>">
                    <input type="hidden" name="sortOrder" value="<?php echo $sortOrder; ?>">
                    <input type="hidden" name="pageNo" value="<?php echo $pageNo; ?>">
                    <input type="hidden" name="pageSize" value="<?php echo $pageSize; ?>">
                    <input type="hidden" name="favorite" value="<?php echo $favorite; ?>">





                    <button type="submit">Search</button>
                    <?php
                    $sortCol = "title";
                    $sortOrder = "";



                    if (isset($_GET['pageNo'])) {
                        $pageNo = $_GET['pageNo'];
                    }
                    if (isset($_GET['pageSize'])) {
                        $pageSize = $_GET['pageSize'];
                    }


                    if (isset($_GET['sortCol'])) {
                        $sortCol = $_GET['sortCol'];
                    }
                    if (isset($_GET['sortOrder'])) {
                        $sortOrder = $_GET['sortOrder'];
                    }
                    if (
                        isset($_GET['q
                    '])
                    ) {
                        $q = $_GET['q'];
                    }
                    if (
                        isset($_GET['categoryId'])
                    ) {
                        $categoryId = $_GET['categoryId'];
                    }


                    foreach ($dbContext->searchProducts($sortCol, $sortOrder, $q, null, $pageNo, $pageSize = 15, $favorite, ) as $product) {
                        echo "<tr>";
                        echo "<td>$product->title</td>";
                        echo "<td>$product->categoryId</td>";
                        echo "<td>$product->price</td>";
                        echo "<td>$product->stockLevel</td>";
                        if ($product->favorite > 0) {
                            echo "<td><strong>$product->favorite</strong></td>";
                        } else {
                            echo "<td>$product->favorite</td>";
                        }
                        echo "<td><a href='viewproduct.php?id=$product->id'>EDIT</a></td>";

                        // Button to add product to cart
                        echo "<td><button onclick='addToCart($product->id)'>Add to Cart</button></td>";

                        echo "</tr>";
                    }









                    ?>

                </form>




            </table>
            <?php
            $pageCount = $dbContext->getProductPageCount($q, $pageSize, $sortCol, $sortOrder, $pageNo);
            for ($i = 1; $i <= $pageCount; $i++) {
                echo "<a href='index.php?q=$q&pageNo=$i&sortCol=$sortCol&sortOrder=$sortOrder&pageSize=$pageSize'>$i</a>&nbsp;";


            }
            echo "<p>Current page: <b> $pageNo</b></p>";
            ?>

        </div>

    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>


</html>