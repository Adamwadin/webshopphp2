<?php
require_once('Models/Product.php');

class DBContext{
    private  $host = '127.0.0.1';
    private  $db   = 'test';
    private  $user = 'root';
    private  $pass = 'hejsan123';
    private  $charset = 'utf8mb4';

    private $pdo;
    
    function __construct() {    
        $dsn = "mysql:host=$th is->host;dbname=$this->db";
        // $options = [
        //     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        //     PDO::ATTR_EMULATE_PREPARES   => false,
        // ];
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
        $this->initIfNotInitialized();
        $this->seedfNotSeeded();



    }

    function getAllProducts(){
        return $this->pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
    function getProduct($id){
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->execute(array(':id'=> $id));
        return  $prep->fetch(PDO::FETCH_CLASS,'Product');
    }
    function getProductByTitle($title){
        $prep = $this->pdo->prepare('SELECT * FROM products where title=:title');
        $prep->execute(array(':title'=> $title));
        return  $prep->fetch(PDO::FETCH_CLASS,'Product');
    }


    function seedfNotSeeded(){
        static $seeded = false;
        if($seeded) return;
        $this->createIfNotExisting('Chai',18,39,'Beverages');
        $seeded = true;

    }

    function createIfNotExisting($title,$price,$stockLevel, $categoryName){
        $existing = $this->getProductByTitle($title);
        if(!$existing){
            return;
        };
        return $this->addProduct($title,$price,$stockLevel, $categoryName);

    }

    function addProduct($title,$price,$stockLevel, $categoryName){
        //insert plus get new id 
        // return id             
        $prep = $this->pdo->prepare('INSERT INTO products (title, price, stockLevel, categoryName) VALUES(:title, :price, :stockLevel, :categoryName )');
        $prep->execute([]]);
        return  $prep->fetch(PDO::FETCH_CLASS,'Product');
                   
    }

    function initIfNotInitialized() {

        static $initialized = false;
        if($initialized) return;

        $sql  ="CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            `price` INT,
            `stockLevel` INT,
            `categoryName` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)) ";

        $this->pdo->exec($sql);

        $initialized = true;
    }


}


?>