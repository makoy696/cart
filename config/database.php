<?php

class Database {

    public $conn = null;

    public function __construct($db,$host,$user,$password) {
        $this->conn = new MySqli($host,$user,$password,$db);
    }

    public function getConn() {
        return $this->conn;
    }

    public function checkTable() {
        $sql = "SHOW TABLES LIKE 'products'";
        $res = $this->conn->query($sql);

        return $res->fetch_assoc();
    }

    public function insertTable () {
        $sql = "CREATE TABLE products (
        product_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        product VARCHAR(250) NOT NULL,
        stock INT(11) NOT NULL,
        price FLOAT(11) NOT NULL
        )";

        if ($this->conn->query($sql) === TRUE) {
            echo "Table created successfully";
        } else {
            echo "Error creating table: " . $this->conn->error;
        }

        $sql = "INSERT INTO products (product, stock, price)
        VALUES ('Product A', '10', '100')";

        $this->conn->query($sql);

        $sql = "INSERT INTO products (product, stock, price)
        VALUES ('Product B', '15', '50')";

        $this->conn->query($sql);

        $sql = "INSERT INTO products (product, stock, price)
        VALUES ('Product C', '5', '200')";

        $this->conn->query($sql);
    }
}
