<?php
    require 'config/database.php';
    require 'controller/controller.php';
    require 'controller/Cart.php';
    $conn = new Database('db_main', 'localhost', 'root', '');
    $conn = $conn->getConn();
    $query = new Controller($conn);

    $products = $query->getAllProducts();
//    echo '<pre>' . print_r($products,true) . '</pre>';
    session_start();
    $cartObj = new Cart($conn);
    $message = "";
    $notif = 'success';
    unset($_SESSION['invalid']);
    unset($_SESSION['success']);
    if (isset($_GET['add'])) {
        $cart = $cartObj->addToCart($_GET);
        if (!$cart) {
            $message = $_SESSION['message'];
            $notif = 'error';
        }
    } else if (isset($_GET['clear'])) {
        session_destroy();
        $_SESSION = [];
        header('Location: index.php');
    } else if (isset($_GET['buy'])) {
        $cartObj->checkOut($_SESSION);
        $products = $query->getAllProducts();
        $message = $_SESSION['message'];
        $_SESSION = [];
    }



//    echo print_r($_SESSION, true);
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
    <?php
    if ($message != "") {
        echo "<div class=\"$notif\">
                    <h3>
                        ".$message."
                    </h3>
                </div>";

    }
    ?>
    <div class="container">
        <div class="row">
            <div class="products-table">
                <table border="1" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    if (!empty($products)) {
                        foreach ($products as $product) {
                            echo "<tr>";
                            echo "<td>".$product['product']."</td>";
                            echo "<td>".$product['stock']."</td>";
                            echo "<td>".$product['price']."</td>";
                            echo "<td><form action='update.php'><input name='{$product['product_id']}' type='submit' value='Update'></form></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="sell-table">
                <form action="">
                    <label>
                        Product
                        <select name="product">
                            <?php
                                foreach ($products as $product) {
                                    echo "<option value='{$product["product_id"]}_{$product["price"]}_{$product['product']}'>" .$product['product']. "</option>";
                                }
                            ?>
                        </select>
                    </label>
                    <label>
                        Quantity
                        <input style="width: 50px;" type="number" name="quantity" value="1">
                    </label>
                    <input name="add" type="submit" value="Add">
                    <input name="clear" type="submit" value="Clear">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="cart-table">
                <h2>Cart</h2>
                <table border="1" cellpadding="0" cellspacing="0">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    <?php
                        if (!empty($cart['cart'])) {
                            foreach ($cart['cart'] as $product) {
                                echo "<tr>";
                                echo "<td>".$product['product']."</td>";
                                echo "<td>".$product['quantity']."</td>";
                                echo "<td>".$product['total']."</td>";
                                echo "</tr>";
                            }
                            echo "<tr>";
                            echo "<td colspan='2'>TOTAL:</td>";
                            echo "<td>".$cart['total']."</td>";
                            echo "</tr>";
                        } else {
                            echo "<tr>";
                            echo "<td colspan='3'>Cart is Empty</td>";
                            echo "</tr>";
                        }
                    ?>

                </table>
                <div style="padding: 10px">
                    <form action="">
                        <input name="buy" type="submit" value="Buy Now">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        const getProduct = id =>  {
            alert(id)
        }
    </script>
</body>
</html>