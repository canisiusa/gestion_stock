<?php
require_once __DIR__ . '/../app/Core/Database.php';

use Core\Database;


// Obtention de l'instance de la connexion à la base de données
$db = Database::getInstance()->getConnection();

// Vérification de l'existence des tables et création si nécessaire
$tables = [
    'users' => [
        'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'email' => 'VARCHAR(255) NOT NULL UNIQUE',
        'address' => 'VARCHAR(255)',
        'phone' => 'VARCHAR(20)',
        'role_id' => 'INT(11) UNSIGNED NOT NULL',
        'password' => 'VARCHAR(100) NOT NULL',
        'created_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ],
    'roles' => [
        'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL UNIQUE',
        'created_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ],
    'products' => [
        'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'image' => 'VARCHAR(255) NOT NULL',
        'description' => 'TEXT',
        'price' => 'DECIMAL(10,2) NOT NULL',
        'quantity' => 'INT(100) NOT NULL',
        'category_id' => 'INT(11) UNSIGNED NOT NULL',
        'supplier_id' => 'INT(11) UNSIGNED NOT NULL',
        'created_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        'deleted_at' => 'DATETIME',
    ],
    'orders' => [
        'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'customer_id' => 'INT(11) UNSIGNED NOT NULL',
        'ordered_at' => 'DATETIME',
        'amount' => 'DECIMAL(10,2) NOT NULL',
        'status' => 'VARCHAR(20) NOT NULL',
        'shipping_address' => 'VARCHAR(255)',
        'product_id' => 'INT(11) UNSIGNED NOT NULL',
        'quantity' => 'INT(11) UNSIGNED NOT NULL',
        'created_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    ],
    'categories' => [
        'id' => 'INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'created_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
        'updated_at' => 'DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
    ],
];

foreach ($tables as $tableName => $columns) {
    $query = "CREATE TABLE IF NOT EXISTS `$tableName` (";
    foreach ($columns as $columnName => $columnDefinition) {
        $query .= "`$columnName` $columnDefinition,";
    }
    $query = rtrim($query, ',');
    $query .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    $db->exec($query);
}


// Vérifier si la contrainte fk_supplier existe déjà
$result = $db->query("SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = 'stock_management_db' AND CONSTRAINT_NAME = 'fk_supplier' AND TABLE_NAME = 'products' AND CONSTRAINT_TYPE = 'FOREIGN KEY'")->fetchColumn();
if ($result == 0) {
    $db->exec("ALTER TABLE products ADD CONSTRAINT fk_supplier FOREIGN KEY (supplier_id) REFERENCES users(id) ON DELETE CASCADE");
}
// Vérifier si la contrainte fk_category existe déjà
$result = $db->query("SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = 'stock_management_db' AND CONSTRAINT_NAME = 'fk_category' AND TABLE_NAME = 'products' AND CONSTRAINT_TYPE = 'FOREIGN KEY'")->fetchColumn();
if ($result == 0) {
    $db->exec("ALTER TABLE products ADD CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE");
}

// Vérifier si la contrainte fk_customer existe déjà
$result = $db->query("SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = 'stock_management_db' AND CONSTRAINT_NAME = 'fk_customer' AND TABLE_NAME = 'orders' AND CONSTRAINT_TYPE = 'FOREIGN KEY'")->fetchColumn();
if ($result == 0) {
    $db->exec("ALTER TABLE orders ADD CONSTRAINT fk_customer FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE");
}
// Vérifier si la contrainte fk_customer existe déjà
$result = $db->query("SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = 'stock_management_db' AND CONSTRAINT_NAME = 'fk_product' AND TABLE_NAME = 'orders' AND CONSTRAINT_TYPE = 'FOREIGN KEY'")->fetchColumn();
if ($result == 0) {
    $db->exec("ALTER TABLE orders ADD CONSTRAINT fk_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE");
}

// Vérifier si la contrainte fk_role existe déjà
$result = $db->query("SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = 'stock_management_db' AND CONSTRAINT_NAME = 'fk_role' AND TABLE_NAME = 'users' AND CONSTRAINT_TYPE = 'FOREIGN KEY'")->fetchColumn();
if ($result == 0) {
    $db->exec("ALTER TABLE users ADD CONSTRAINT fk_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE");
}
