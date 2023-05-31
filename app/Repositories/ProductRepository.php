<?php

namespace App\Repositories;

use PDO;
use Core\Database;

require_once __DIR__ . '/../Domain/Entities/Product.php';
require_once __DIR__ . '/../Domain/Entities/User.php';
require_once __DIR__ . '/../Domain/Entities/Category.php';

use App\Domain\Entities\Product;
use App\Domain\Entities\User;
use App\Domain\Entities\Category;

class ProductRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findById(int $id): ?Product
    {
        $stmt = $this->pdo->prepare('SELECT p.*, c.name AS category_name, u.name AS supplier_name, u.email AS supplier_email
        FROM products p
        JOIN categories c ON p.category_id = c.id
        JOIN users u ON p.supplier_id = u.id
        WHERE p.deleted_at IS NULL AND p.id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Product(
            id: $data['id'],
            name: $data['name'],
            category: new Category(id: $data['category_id'], name: $data['category_name']),
            supplier: new User(id: $data['supplier_id'], name: $data['supplier_name'], email : $data['supplier_email']),
            quantity: $data['quantity'],
            price: $data['price'],
            description: $data['description'],
            image: $data['image'],
            created_at: $data['created_at'],
            updated_at: $data['updated_at']
        ) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('
        SELECT p.*, c.name AS category_name, u.name AS supplier_name, u.email AS supplier_email
        FROM products p
        JOIN categories c ON p.category_id = c.id
        JOIN users u ON p.supplier_id = u.id
        WHERE p.deleted_at IS NULL');
        $products = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                id: $data['id'],
                name: $data['name'],
                category: new Category(id: $data['category_id'], name: $data['category_name']),
                supplier: new User(id: $data['supplier_id'], name: $data['supplier_name'],),
                quantity: $data['quantity'],
                price: $data['price'],
                description: $data['description'],
                image: $data['image'],
                created_at: $data['created_at'],
                updated_at: $data['updated_at']
            );
        }
        return $products;
    }

    public function findAllInStock(): array
    {
        $stmt = $this->pdo->query('
        SELECT p.*, c.name AS category_name, u.name AS supplier_name, u.email AS supplier_email
        FROM products p
        JOIN categories c ON p.category_id = c.id
        JOIN users u ON p.supplier_id = u.id
        WHERE p.deleted_at IS NULL AND p.quantity > 0');
        $products = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                id: $data['id'],
                name: $data['name'],
                category: new Category(id: $data['category_id'], name: $data['category_name']),
                supplier: new User(id: $data['supplier_id'], name: $data['supplier_name'],),
                quantity: $data['quantity'],
                price: $data['price'],
                description: $data['description'],
                image: $data['image'],
                created_at: $data['created_at'],
                updated_at: $data['updated_at']
            );
        }
        return $products;
    }

    public function findByName(string $name): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE name LIKE ?');
        $stmt->execute(['%' . $name . '%']);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($data as $categoryData) {
            $products[] = new Product(id: $categoryData['id'],  name: $categoryData['name'], category: new Category(id: $categoryData['category_id']), supplier: new User(id: $categoryData['supplier_id']), quantity: $categoryData['quantity'], price: $categoryData['price'], description: $categoryData['description'], image: $categoryData['image'],  created_at: $categoryData['created_at'], updated_at: $categoryData['updated_at']);
        }

        return $products;
    }

    public function save(Product $product): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO products (name, image, description, price, quantity, category_id, supplier_id) VALUES (?,?,?,?,?,?,?)');
        $stmt->execute([$product->getName(), $product->getImage(), $product->getDescription(), $product->getPrice(), $product->getQuantity(), $product->getCategory()->getId(), $product->getSupplier()->getId()]);
    }

    public function findBySupplierId($supplier_id): array
    {
        $stmt = $this->pdo->prepare('SELECT products.*, categories.name AS category_name FROM products INNER JOIN categories ON products.category_id = categories.id WHERE supplier_id = ? AND products.deleted_at IS NULL');
        $stmt->execute([$supplier_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($data as $productData) {
            $products[] = new Product(id: $productData['id'],  name: $productData['name'], category: new Category(id: $productData['category_id'], name: $productData['category_name']), supplier: new User(id: $productData['supplier_id']), quantity: $productData['quantity'], price: $productData['price'], description: $productData['description'], image: $productData['image'],  created_at: $productData['created_at'], updated_at: $productData['updated_at']);
        }
        return $products;
    }

    public function delete($id)
    {

        $stmt = $this->pdo->prepare("UPDATE products SET deleted_at = :deleted_at WHERE id = :id");

        $deletedAt = date("Y-m-d H:i:s");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':deleted_at', $deletedAt);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "La modification du produit a été effectuée avec succès.";
        } else {
            echo "Aucun produit n'a été modifié.";
        }
        return;
    }

    public function update(Product $product): void
    {
        $stmt = $this->pdo->prepare("UPDATE products SET name = :name, price = :price, quantity = :quantity, category_id = :category_id, description = :description WHERE id = :id");
        $stmt->bindParam(':name', $product->getName());
        $stmt->bindParam(':price', $product->getPrice());
        $stmt->bindParam(':quantity', $product->getQuantity());
        $stmt->bindParam(':category_id', $product->getCategory()->getId());
        $stmt->bindParam(':description', $product->getDescription());
        $stmt->bindParam(':id', $product->getId());
        $stmt->execute();
        return;
    }

    public function searchProducts($searchTerm): array
    {
        $stmt = $this->pdo->prepare("
        SELECT p.*, c.name AS category_name, s.name AS supplier_name
        FROM products AS p
        INNER JOIN categories AS c ON p.category_id = c.id
        INNER JOIN users AS s ON p.supplier_id = s.id
        WHERE p.deleted_at IS NULL AND (p.name LIKE :search OR c.name LIKE :search OR s.name LIKE :search)
        ");
        $stmt->bindValue(':search', '%' . $searchTerm . '%');
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($data as $productData) {
            $products[] = new Product(
                id: $productData['id'],
                name: $productData['name'],
                category: new Category(id: $productData['category_id'], name: $productData['category_name']),
                supplier: new User(id: $productData['supplier_id'], name: $productData['supplier_name'],),
                quantity: $productData['quantity'],
                price: $productData['price'],
                description: $productData['description'],
                image: $productData['image'],
                created_at: $productData['created_at'],
                updated_at: $productData['updated_at']
            );
        }

        return $products;
    }
}
