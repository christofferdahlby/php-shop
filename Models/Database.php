<?php

require_once("vendor/autoload.php");

class Database
{
    public PDO $pdo;

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
    }

    function getAllProducts()
    {
        $query = $this->pdo->query("
            SELECT
                product.id,
                artist,
                category.category_name AS genre,
                description,
                record_title,
                price,
                imageUrl,
                release_year,
                stockLevel
            FROM product
            JOIN category
            ON product.category_id = category.id
        ");

        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product");

        return $products;
    }

    function getAllCategories()
    {
        $query = $this->pdo->query("
            SELECT category_name
            FROM category
        ");

        $categories = $query->fetchAll(PDO::FETCH_COLUMN, 0);

        return $categories;
    }

    function getProduct($id)
    {
        $query = $this->pdo->prepare("
            SELECT
                product.id,
                artist,
                category.category_name AS genre,
                description,
                record_title,
                price,
                imageUrl,
                release_year,
                stockLevel
            FROM product
            JOIN category
            ON product.category_id = category.id
            WHERE product.id = :id
        ");

        $query->execute([
            "id" => $id
        ]);

        $query->setFetchMode(PDO::FETCH_CLASS, "Product");

        return $query->fetch();
    }

    function updateProductPriceAndStock($id, $price, $stockLevel)
    {
        $query = $this->pdo->prepare("
            UPDATE product
            SET price = :price,
                stockLevel = :stockLevel
            WHERE id = :id
        ");

        $query->execute([
            "price" => $price,
            "stockLevel" => $stockLevel,
            "id" => $id,
        ]);

        return $query->rowCount();
    }

    function getProductsByGenre($genre)
    {
        $query = $this->pdo->prepare("
            SELECT
                product.id,
                artist,
                category.category_name AS genre,
                description,
                record_title,
                price,
                imageUrl,
                release_year,
                stockLevel
            FROM product
            JOIN category
            ON product.category_id = category.id
            WHERE category.category_name = :genre
        ");

        $query->execute([
            "genre" => $genre
        ]);

        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product");

        return $products;
    }

    function searchProducts($searchWord)
    {
        $query = $this->pdo->prepare("
            SELECT
                product.id,
                artist,
                category.category_name AS genre,
                description,
                record_title,
                price,
                imageUrl,
                release_year,
                stockLevel
            FROM product
            JOIN category
            ON product.category_id = category.id
            WHERE record_title LIKE :searchWord
            OR artist LIKE :searchWord
        ");

        $searchWordWithProcent = '%' . $searchWord . '%';

        $query->execute([
            'searchWord' => $searchWordWithProcent
        ]);

        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product");

        return $products;
    }

    function getCartItems($userId, $sessionId)
    {
        if ($userId != null) {
            $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId WHERE userId IS NULL AND  sessionId = :sessionId");
            $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);
        }

        $query = $this->pdo->prepare("SELECT CartItem.Id as id, CartItem.productId, CartItem.quantity, product.record_title as productName, product.price as productPrice, product.price * CartItem.quantity as rowPrice     FROM CartItem JOIN product ON product.id=CartItem.productId  WHERE userId=:userId or sessionId = :sessionId");
        $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);


        return $query->fetchAll(PDO::FETCH_CLASS, 'CartItem');
    }

    function convertSessionToUser($session_id, $userId, $newSessionId)
    {
        $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId, sessionId=:newSessionId WHERE sessionId = :sessionId");
        $query->execute(['sessionId' => $session_id, 'userId' => $userId, 'newSessionId' => $newSessionId]);
    }

    function updateCartItem($userId, $sessionId, $productId, $quantity)
    {
        if ($quantity <= 0) {
            $query = $this->pdo->prepare("DELETE FROM CartItem WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
            $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
            return;
        }
        $query = $this->pdo->prepare("SELECT * FROM CartItem  WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
        $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId]);
        if ($query->rowCount() == 0) {
            $query = $this->pdo->prepare("INSERT INTO CartItem (productId, quantity, sessionId, userId) VALUES (:productId, :quantity, :sessionId, :userId)");
            $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
        } else {
            $query = $this->pdo->prepare("UPDATE CartItem SET quantity = :quantity WHERE (userId=:userId or sessionId=:sessionId) AND productId = :productId");
            $query->execute(['userId' => $userId, 'sessionId' => $sessionId, 'productId' => $productId, 'quantity' => $quantity]);
        }
    }


}
?>