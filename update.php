<?php

require 'config/database.php';
require 'controller/controller.php';
require 'controller/Cart.php';
$conn = new Database('db_main', 'localhost', 'root', '');
$conn = $conn->getConn();

$query = new Controller($conn);




if (isset($_GET['update'])) {
    $query->updateProduct($_GET);
    header('Location: index.php');
} else {
    $product = $query->getProduct(array_keys($_GET)[0]);
}

?>

<html lang="en">
<head>
    <title>Trial Project</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav>
    <div class="nav-bar">
        <h1>Trial Project</h1>
    </div>
</nav>
<div class="container">
    <div class="row">
        <form action="">
            <label>
                Product
                <input name="product" type="text" value="<?= $product['product'] ?>">
            </label>
            <label>
                Stock
                <input name="stock" type="number" value="<?= $product['stock'] ?>">
            </label>
            <label>
                Price
                <input name="price" type="text" value="<?= $product['price'] ?>">
                <input name="product_id" type="hidden" value="<?= $product['product_id'] ?>">
            </label>
            <input name="update" type="submit" value="Update">
        </form>
    </div>
</div>
</body>
</html>
