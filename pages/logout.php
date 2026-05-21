<?php
ob_start();
require_once(__DIR__ . '/../Models/Database.php');

$database = new Database();
$database->getUsersDatabase()->getAuth()->logOut();

header("Location: /");
exit();

?>