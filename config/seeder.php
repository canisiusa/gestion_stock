<?php

require_once __DIR__ . '/../app/Core/Database.php';

use Core\Database;

$db = Database::getInstance()->getConnection();

// Vider la table "roles"
$db->exec("DELETE FROM roles");

// Ajout des rôles
$db->exec("INSERT INTO roles (id, name, created_at, updated_at) VALUES (1, 'admin',NOW(), NOW())");
$db->exec("INSERT INTO roles (id, name, created_at, updated_at) VALUES (2, 'supplier',NOW(), NOW())");
$db->exec("INSERT INTO roles (id, name, created_at, updated_at) VALUES (3, 'client',NOW(), NOW())");
echo "Roles seeded successfully.\n";



// Ajout de l'utilisateur avec le rôle "admin" s'il n'existe pas déjà
$email = 'admin@gmail.com';
$password = 'password';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetchColumn() == 0) {
    $db->exec("INSERT INTO `users` (`name`, `email`, `role_id`, `password`, `created_at`, `updated_at`)
               VALUES ('ADOGNON Canisius', '$email', 1, '$hashedPassword', NOW(), NOW())");
} else {
    $db->exec("UPDATE users SET role_id = 1 WHERE email = '$email'");
}

// Suppression des utilisateurs avec le rôle 'admin' s'il y en a plus d'un
$numAdmins = $db->query("SELECT COUNT(*) FROM `users` WHERE `role_id` = 1")->fetchColumn();
if ($numAdmins > 1) {
    $db->exec("DELETE FROM `users` WHERE `role_id` = 1 AND `email` != '$email'");
}
echo "User seeded successfully.\n";


// Définition des catégories à insérer
$db->exec("DELETE FROM categories");
$categories = [
    ['id' => 1, 'name' => 'Produits électroniques'],
    ['id' => 2, 'name' => 'Vêtements'],
    ['id' => 3, 'name' => 'Maison et Cuisine'],
    ['id' => 4, 'name' => 'Livres'],
];

// Insertion des catégories dans la base de données
foreach ($categories as $categoryData) {
    $id = $categoryData['id'];
    $name = $categoryData['name'];
    $db->exec("INSERT INTO categories (id, name) VALUES ('$id', '$name')");
}

echo "Categories seeded successfully.\n";