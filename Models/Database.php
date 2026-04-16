<?php
class Database
{
    public $pdo; // php data object - används för att ansluta till databas och göra queries

    function __construct()
    {
        // I know!!! Stupid! We will use .env soon!!!
        $host = "localhost";
        $db = "recordstore";
        $user = "root";
        $pass = "root";
        $port = 3306;

        $dsn = "mysql:host=$host;port=$port;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        // NU HAR VI EN KOPPLING (CONNECTION) TILL VÅR DATABAS OCH KAN GÖRA QUERIES
    }

    function getAllProducts()
    {
        $query = $this->pdo->query("SELECT id, artist, genre, description, record_title, price, imageUrl, release_year,stockLevel FROM product");
        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product"); // KLASSNAMNET!!!
        return $products;
    }
    function getAllCategories()
    {
        $query = $this->pdo->query("SELECT DISTINCT genre FROM product");
        $categories = $query->fetchAll(PDO::FETCH_COLUMN, 0);
        return $categories;
    }
}
;

?>