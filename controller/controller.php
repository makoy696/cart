<?php

class Controller {

    private $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        $res = $this->db->query($sql);
        $data = array();
        while ($rows = $res->fetch_assoc()) {
            $data[] = $rows;
        }
        return $data;
    }

    public function getProduct($product_id) {
        $sql = "SELECT * FROM products WHERE product_id = $product_id";
        $res = $this->db->query($sql);
        return $res->fetch_assoc();
    }

    public function updateProduct($data) {
        $sql = "UPDATE products SET product = '{$data['product']}', stock = '{$data['stock']}', price = '{$data['price']}'
               WHERE product_id = {$data['product_id']}";

        $this->db->query($sql);
        $_SESSION['message'] = 'UPDATED PRODUCT SUCCESSFULLY';
        return true;
    }

}
