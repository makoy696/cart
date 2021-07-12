<?php

class Cart {

    private $conn = null;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addToCart($cart) {
        list($product_id, $price, $product) = explode("_",$cart['product']);
        $current = $this->checkQuantity($product_id);

        if ($cart['quantity'] > $current['stock']) {
            $_SESSION['invalid'] = 1;
            $_SESSION['message'] = 'Quantity is above current stock';
            return false;
        }
        $_SESSION['cart'][$product_id] = array('product_id' => $product_id, 'product' => $product,
            'price' => $price,
            'quantity' => $cart['quantity'],
            'total' => $price * $cart['quantity']);
        $total = 0;
        foreach ($_SESSION['cart'] as $cart) {
            $total += $cart['total'];
        }
        $_SESSION['total'] = $total;

        return $_SESSION;
    }

    public function checkQuantity($product_id) {
        $sql = "SELECT stock FROM products WHERE product_id = $product_id";

        $res = $this->conn->query($sql);

        return $res->fetch_assoc();
    }

    public function checkOut($cart) {

        foreach ($cart['cart'] as $item) {
            $sql = "UPDATE products SET stock = stock - {$item['quantity']} 
                    WHERE product_id = {$item['product_id']}";
            $this->conn->query($sql);
        }

        $_SESSION['message'] = 'Checkout Successful';
        return true;
    }

}