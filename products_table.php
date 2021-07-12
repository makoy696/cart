<?php

require 'config/database.php';
require 'controller/controller.php';
require 'controller/Cart.php';
$conn = new Database('db_main', 'localhost', 'root', '');
$conn = $conn->getConn();

$sql = "CREATE TABLE products (
product_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
product VARCHAR(250) NOT NULL,
stock INT(11) NOT NULL,
price FLOAT(11) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$sql = "INSERT INTO products (product, stock, price)
VALUES ('Product A', '10', '100')";

$conn->query($sql);

$sql = "INSERT INTO products (product, stock, price)
VALUES ('Product B', '15', '50')";

$conn->query($sql);

$sql = "INSERT INTO products (product, stock, price)
VALUES ('Product C', '5', '200')";

$conn->query($sql);