<?php
// файл выгрузки и показа продуктов из базы данных opencart

$mysqli = new MySQLi('127.0.0.1', 'root', '', 'opencart_test');
if (!$mysqli) {
    die('Ошибка соединения: ' . mysqli_error());
}

echo '<pre>';
$query = 'SELECT model, quantity, price FROM oc_product';
if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        printf ("Model: %s\nQuantity: %s\nPrice: %s\n\n", $row["model"], $row["quantity"], $row["price"]);
    }
}