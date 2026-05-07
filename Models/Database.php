<?php
require_once("vendor/autoload.php");
class Database
{
    public $pdo; // php data object - används för att ansluta till databas och göra queries

    function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $host = $_ENV['DATABASE_HOST'];
        $db = $_ENV['DATABASE_NAME'];
        $user = $_ENV['DATABASE_USER'];
        $pass = $_ENV['DATABASE_PASS'];
        $port = $_ENV['DATABASE_PORT'];

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

    function getProduct($id)
    {
        $query = $this->pdo->prepare("SELECT id, artist, genre, description, record_title, price, imageUrl, release_year,stockLevel FROM product WHERE id = :id");
        $query->execute(["id" => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, "Product");
        return $query->fetch();
    }

    function updateProductPriceAndStock($id, $price, $stockLevel)
    {
        $query = $this->pdo->prepare("UPDATE product SET price = :price, stockLevel = :stockLevel WHERE id = :id");
        $query->execute([
            "price" => $price,
            "stockLevel" => $stockLevel,
            "id" => $id,
        ]);
        return $query->rowCount();
    }

    function getProductsByGenre($genre)
    {
        $query = $this->pdo->prepare("SELECT id, artist, genre, description, record_title, price, imageUrl, release_year, stockLevel FROM product WHERE genre = :genre");
        $query->execute(["genre" => $genre]);
        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product");
        return $products;
    }

    function searchProducts($searchWord)
    {
        $query = $this->pdo->prepare("SELECT id, artist, genre, description, record_title, price, imageUrl, release_year, stockLevel FROM product WHERE record_title like :searchWord OR artist like :searchWord");
        $searchWordWithProcent = '%' . $searchWord . '%';
        $query->execute(['searchWord' => $searchWordWithProcent]);

        //$query->execute(['searchWord' => '%' . $searchWord . '%']);
        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product"); // KLASSNAMNET!!!
        return $products;
    }
}
;
?>