<?php
$dsn = 'mysql:dbname=example;host=127.0.0.1';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    //echo 'Изменено имя: ' . $dbh->exec("ALTER TABLE product CHANGE COLUMN product_manuf product_name VARCHAR(50)");
    $sth = $dbh->query("SELECT * FROM product");
    $sth->setFetchMode(PDO::FETCH_CLASS, 'Products');
    while ($product = $sth->fetch()) {
        echo $product;
    }
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}
class Products {
    private $product_name;
    private $product_type;
    private $product_price;
    private $catalog_id;

    function __toString() {
        $product_info = 'Product_name: ' . $this->product_name;
        $product_info .= '<br/>Product_type: ' . $this->product_type;
        $product_info .=  '<br/>Product_price: ' . $this->product_price;
        $product_info .=  '<br/>Catalog_id: ' . $this->catalog_id . '<br/>';
        return $product_info;
    }
}