<?php
require_once("Models/Category.php");
require_once("Models/Product.php");
require_once("Models/Cart.php");
require_once("Models/CartItem.php");
require_once("Models/FreightRule.php");
require_once("vendor/autoload.php");
require_once("Models/UserDatabase.php");

class Database
{
    public PDO $pdo;

    private $usersDatabase;
    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }

    function saveUserDetails($userId, $name, $street, $postal_code, $city)
    {
        $query = $this->pdo->prepare("INSERT INTO UserDetails (userid, streetaddress, name, postalCode, city) VALUES (:userid, :streetaddress, :name, :postalCode, :city)");
        $query->execute([
            "userid" => $userId,
            "streetaddress" => $street,
            "name" => $name,
            "postalCode" => $postal_code,
            "city" => $city
        ]);
    }
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

        $this->usersDatabase = new UserDatabase($this->pdo);
        $this->usersDatabase->setupUsers();
        $this->usersDatabase->seedUsers();
    }

    function getAllProducts($sort, $order, $limit, $offset)
    {
        // sql injection - vid sort/order by
        if (!in_array($sort, ['record_title', 'price'])) {
            $sort = 'record_title';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

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
            stockLevel,
            weight
        FROM product
        JOIN category
        ON product.category_id = category.id
        ORDER BY $sort $order
        LIMIT :limit OFFSET :offset
    ");

        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, "Product");
    }

    function listAllProducts()
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
                stockLevel,
                weight
            FROM product
            JOIN category
            ON product.category_id = category.id
        ");
        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product"); // KLASSNAMNET!!!
        return $products;
    }
    function getPopularProducts()
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
                stockLevel,
                weight
            FROM product
            JOIN category
            ON product.category_id = category.id
            ORDER BY popularityFactor
            DESC LIMIT 0,4
            ");
        $products = $query->fetchAll(PDO::FETCH_CLASS, "Product"); // KLASSNAMNET!!!
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

    function getAllFreightRules()
    {
        $query = $this->pdo->query("SELECT id, zone_code as zoneCode, zone_name as zoneName, base_fee as baseFee, weight_modifier as weightMultiplier, free_shipping_threshold as freeShippingThreshold FROM freight_rules");
        $freightRules = $query->fetchAll(PDO::FETCH_CLASS, "FreightRule"); // KLASSNAMNET!!!
        return $freightRules;
    }

    function getFreightRule($id)
    {
        $query = $this->pdo->prepare("SELECT id, zone_code as zoneCode, zone_name as zoneName, base_fee as baseFee, weight_modifier as weightMultiplier, free_shipping_threshold as freeShippingThreshold FROM freight_rules WHERE id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'FreightRule');
        // TA SQL FRÅGA OCH KÖR I MYSQL
        // OCH OMVANDLA SVARET TILL EN PRODUCT-OBJEKT
        return $query->fetch();
    }
    function updateFreightRule($zoneCode, $zoneName, $baseFee, $weightMultiplier, $freeShippingLimit)
    {
        //    
        $query = $this->pdo->prepare("INSERT INTO freight_rules (zone_code, zone_name, base_fee, weight_modifier," .
            " free_shipping_threshold) VALUES (:zoneCode, :zoneName, :baseFee, :weight_modifier, :free_shipping_threshold)" .
            " ON DUPLICATE KEY UPDATE zone_name=:zoneName, base_fee=:baseFee, weight_modifier=:weight_modifier, free_shipping_threshold=:free_shipping_threshold");
        $query->execute([
            'zoneCode' => $zoneCode,
            'zoneName' => $zoneName,
            'baseFee' => $baseFee,
            'weight_modifier' => $weightMultiplier,
            'free_shipping_threshold' => $freeShippingLimit
        ]);
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
                stockLevel,
                weight
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
    function getProductsForCategory($categoryId, $sort, $order, $limit, $offset)
    {
        if (!in_array($sort, ['record_title', 'price'])) {
            $sort = 'record_title';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

        $query = $this->pdo->prepare("
        SELECT 
            product.id,
            product.artist,
            category.category_name AS genre,
            product.description,
            product.record_title,
            product.price,
            product.imageUrl,
            product.release_year,
            product.stockLevel,
            product.weight
        FROM product
        JOIN category
            ON product.category_id = category.id
        WHERE product.category_id = :categoryId
        ORDER BY $sort $order
        LIMIT :limit OFFSET :offset
    ");

        $query->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, "Product");
    }

    function getProductCountForCategory($categoryId)
    {
        $query = $this->pdo->prepare("
        SELECT COUNT(*) 
        FROM product 
        WHERE category_id = :categoryId
    ");

        $query->execute(['categoryId' => $categoryId]);

        return $query->fetchColumn();
    }
    function getTotalProductCount()
    {
        $query = $this->pdo->query("
        SELECT COUNT(*) FROM product
    ");

        return $query->fetchColumn();
    }
    function getGenre($genre)
    {
        $query = $this->pdo->prepare("SELECT * FROM category WHERE category_name = :category_name");
        $query->execute(['category_name' => $genre]);
        $query->setFetchMode(PDO::FETCH_CLASS, "Category");

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
                stockLevel,
                weight
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

    function searchProducts($searchWord, $sort, $order, $limit, $offset)
    {
        if (!in_array($sort, ['record_title', 'price'])) {
            $sort = 'record_title';
        }

        if (!in_array($order, ['asc', 'desc'])) {
            $order = 'asc';
        }

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
            stockLevel,
            weight
        FROM product
        JOIN category ON product.category_id = category.id
        WHERE record_title LIKE :searchWord
        OR artist LIKE :searchWord
        ORDER BY $sort $order
        LIMIT :limit OFFSET :offset
    ");

        $query->bindValue(':searchWord', '%' . $searchWord . '%');
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS, "Product");
    }

    function getSearchProductCount($searchWord)
    {
        $query = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM product
        WHERE record_title LIKE :searchWord
        OR artist LIKE :searchWord
    ");

        $query->execute([
            'searchWord' => '%' . $searchWord . '%'
        ]);

        return $query->fetchColumn();
    }

    function getCartItems($userId, $sessionId)
    {
        if ($userId != null) {
            $query = $this->pdo->prepare("UPDATE CartItem SET userId=:userId WHERE userId IS NULL AND  sessionId = :sessionId");
            $query->execute(['sessionId' => $sessionId, 'userId' => $userId]);
        }

        $query = $this->pdo->prepare("
            SELECT 
                CartItem.Id as id,
                CartItem.productId,
                CartItem.quantity,

                product.record_title as productName,
                product.artist,
                product.imageUrl,
                product.price as productPrice,
                product.weight as weight,
                product.price * CartItem.quantity as rowPrice

            FROM CartItem

            JOIN product 
            ON product.id = CartItem.productId

            WHERE userId=:userId 
            OR sessionId = :sessionId
        ");

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

    function clearCart($userId, $sessionId)
    {
        $query = $this->pdo->prepare("
        DELETE FROM CartItem
        WHERE userId = :userId
        OR sessionId = :sessionId
    ");

        $query->execute([
            'userId' => $userId,
            'sessionId' => $sessionId
        ]);
    }


}
?>