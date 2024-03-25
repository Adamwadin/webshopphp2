<?php
require_once('Models/Product.php');
require_once('Models/Category.php');

class DBContext{
    private  $host = 'localhost';
    private  $db   = 'produktdatabas';
    private  $user = 'root';
    private  $pass = 'hejsan123';
    private  $charset = 'utf8mb4';

    private $pdo;
    
    function __construct() {    
        $dsn = "mysql:host=$this->host;dbname=$this->db";
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
        $this->initIfNotInitialized();
        $this->seedfNotSeeded();
    }

    function getAllCategories(){
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Category');
        
    }
    


    function getAllProducts(){
        return $this->pdo->query('SELECT * FROM products')->fetchAll(PDO::FETCH_CLASS, 'Product');
    }
    function getProduct($id){
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS,'Product');
        $prep->execute(['id'=> $id]);
        return  $prep->fetch();
    }
    function getProductByTitle($title){
        $prep = $this->pdo->prepare('SELECT * FROM products where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS,'Product');
        $prep->execute(['title'=> $title]); 
        return  $prep->fetch();
    }

    function getCategoryByTitle($title) : Category | false{
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS,'Category');
        $prep->execute(['title'=> $title]); 
        return  $prep->fetch();
    }



    function seedfNotSeeded(){
        static $seeded = false;
        if($seeded) return;
        $this->createIfNotExisting('Chai',18,39,'Beverages');
        $this->createIfNotExisting('Chang',19,17,'Beverages');
        $this->createIfNotExisting('Aniseed Syrup',10,13,'Condiments');
        $this->createIfNotExisting('Chef Antons Cajun Seasoning',22,53,'Condiments');
        $this->createIfNotExisting('Chef Antons Gumbo Mix',21,0,'Condiments');
        $this->createIfNotExisting('Grandmas Boysenberry Spread',25,120,'Condiments');
        $this->createIfNotExisting('Uncle Bobs Organic Dried Pears',30,15,'Produce');
        $this->createIfNotExisting('Northwoods Cranberry Sauce',40,6,'Condiments');
        $this->createIfNotExisting('Mishi Kobe Niku',97,29,'Meat/Poultry');
        $this->createIfNotExisting('Ikura',31,31,'Seafood');
        $this->createIfNotExisting('Queso Cabrales',21,22,'Dairy Products');
        $this->createIfNotExisting('Queso Manchego La Pastora',38,86,'Dairy Products');
        $this->createIfNotExisting('Konbu',6,24,'Seafood');
        $this->createIfNotExisting('Tofu',22,35,'Produce');
        $this->createIfNotExisting('Genen Shouyu',18,39,'Condiments');
        $this->createIfNotExisting('Pavlova',12,29,'Confections');
        $this->createIfNotExisting('Alice Mutton',39,0,'Meat/Poultry');
        $this->createIfNotExisting('Carnarvon Tigers',231,42,'Seafood');
        $this->createIfNotExisting('Teatime Chocolate Biscuits',213,25,'Confections');
        $this->createIfNotExisting('Sir Rodneys Marmalade',81,40,'Confections');
        $this->createIfNotExisting('Sir Rodneys Scones',10,3,'Confections');
        $this->createIfNotExisting('Gustafs Knäckebröd',21,104,'Grains/Cereals');
        $this->createIfNotExisting('Tunnbröd',9,61,'Grains/Cereals');
        $this->createIfNotExisting('Guaraná Fantástica',231,20,'Beverages');
        $this->createIfNotExisting('NuNuCa Nuß-Nougat-Creme',14,76,'Confections');
        $this->createIfNotExisting('Gumbär Gummibärchen',312,15,'Confections');
        $this->createIfNotExisting('Schoggi Schokolade',213,49,'Confections');
        $this->createIfNotExisting('Rössle Sauerkraut',132,26,'Produce');
        $this->createIfNotExisting('Thüringer Rostbratwurst',231,0,'Meat/Poultry');
        $this->createIfNotExisting('Nord-Ost Matjeshering',321,10,'Seafood');
        $this->createIfNotExisting('Gorgonzola Telino',321,0,'Dairy Products');
        $this->createIfNotExisting('Mascarpone Fabioli',32,9,'Dairy Products');
        $this->createIfNotExisting('Geitost',12,112,'Dairy Products');
        $this->createIfNotExisting('Sasquatch Ale',14,111,'Beverages');
        $this->createIfNotExisting('Steeleye Stout',18,20,'Beverages');
        $this->createIfNotExisting('Inlagd Sill',19,112,'Seafood');
        $this->createIfNotExisting('Gravad lax',26,11,'Seafood');
        $this->createIfNotExisting('Côte de Blaye',1,17,'Beverages');
        $this->createIfNotExisting('Chartreuse verte',18,69,'Beverages');
        $this->createIfNotExisting('Boston Crab Meat',2,123,'Seafood');
        $this->createIfNotExisting('Jacks New England Clam Chowder',2,85,'Seafood');
        $this->createIfNotExisting('Singaporean Hokkien Fried Mee',14,26,'Grains/Cereals');
        $this->createIfNotExisting('Ipoh Coffee',46,17,'Beverages');
        $this->createIfNotExisting('Gula Malacca',2,27,'Condiments');
        $this->createIfNotExisting('Rogede sild',3,5,'Seafood');
        $this->createIfNotExisting('Spegesild',12,95,'Seafood');
        $this->createIfNotExisting('Zaanse koeken',4,36,'Confections');
        $this->createIfNotExisting('Chocolade',6,15,'Confections');
        $this->createIfNotExisting('Maxilaku',5,10,'Confections');
        $this->createIfNotExisting('Valkoinen suklaa',1,65,'Confections');
        $this->createIfNotExisting('Manjimup Dried Apples',53,20,'Produce');
        $this->createIfNotExisting('Filo Mix',7,38,'Grains/Cereals');
        $this->createIfNotExisting('Perth Pasties',4,0,'Meat/Poultry');
        $this->createIfNotExisting('Tourtière',7,21,'Meat/Poultry');
        $this->createIfNotExisting('Pâté chinois',24,115,'Meat/Poultry');
        $this->createIfNotExisting('Gnocchi di nonna Alice',38,21,'Grains/Cereals');
        $this->createIfNotExisting('Ravioli Angelo',7,36,'Grains/Cereals');
        $this->createIfNotExisting('Escargots de Bourgogne',7,62,'Seafood');
        $this->createIfNotExisting('Raclette Courdavault',55,79,'Dairy Products');
        $this->createIfNotExisting('Camembert Pierrot',34,19,'Dairy Products');
        $this->createIfNotExisting('Sirop dérable',7,113,'Condiments');
        $this->createIfNotExisting('Tarte au sucre',7,17,'Confections');
        $this->createIfNotExisting('Vegie-spread',7,24,'Condiments');
        $this->createIfNotExisting('Wimmers gute Semmelknödel',7,22,'Grains/Cereals');
        $this->createIfNotExisting('Louisiana Fiery Hot Pepper Sauce',7,76,'Condiments');
        $this->createIfNotExisting('Louisiana Hot Spiced Okra',17,4,'Condiments');
        $this->createIfNotExisting('Laughing Lumberjack Lager',14,52,'Beverages');
        $this->createIfNotExisting('Scottish Longbreads',8,6,'Confections');
        $this->createIfNotExisting('Gudbrandsdalsost',8,26,'Dairy Products');
        $this->createIfNotExisting('Outback Lager',15,15,'Beverages');
        $this->createIfNotExisting('Flotemysost',8,26,'Dairy Products');
        $this->createIfNotExisting('Mozzarella di Giovanni',8,14,'Dairy Products');
        $this->createIfNotExisting('Röd Kaviar',15,101,'Seafood');
        $this->createIfNotExisting('Longlife Tofu',10,4,'Produce');
        $this->createIfNotExisting('Rhönbräu Klosterbier',9,125,'Beverages');
        $this->createIfNotExisting('Lakkalikööri',9,57,'Beverages');
        $this->createIfNotExisting('Original Frankfurter grüne Soße',13,32,'Condiments');
        $this->createIfNotExisting('Tidningen Buster',13,32,'Tidningar');        
        $seeded = true;

    }

    function createIfNotExisting($title,$price,$stockLevel, $categoryName){
        $existing = $this->getProductByTitle($title);
        if($existing){
            return;
        };
        return $this->addProduct($title,$price,$stockLevel, $categoryName);

    }

    function addCategory($title){
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title"=>$title]);
        return $this->pdo->lastInsertId();
    }


    function addProduct($title,$price,$stockLevel, $categoryName){

        $category = $this->getCategoryByTitle($categoryName);
        if($category == false){
            $this->addCategory($categoryName);
            $category = $this->getCategoryByTitle($categoryName);
        }


        //insert plus get new id 
        // return id             
        $prep = $this->pdo->prepare('INSERT INTO products (title, price, stockLevel, categoryId) VALUES(:title, :price, :stockLevel, :categoryId )');
        $prep->execute(["title"=>$title,"price"=>$price,"stockLevel"=>$stockLevel,"categoryId"=>$category->id]);
        return $this->pdo->lastInsertId();
                   
    }

    function initIfNotInitialized() {

        static $initialized = false;
        if($initialized) return;


        $sql  ="CREATE TABLE IF NOT EXISTS `category` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
            ) ";

        $this->pdo->exec($sql);

        $sql  ="CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            `price` INT,
            `stockLevel` INT,
            `categoryId` INT NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
                REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $initialized = true;
    }


}


?>