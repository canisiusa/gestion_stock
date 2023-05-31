<?php

namespace App\Repositories;

use PDO;
use Core\Database;

require_once __DIR__ . '/../Domain/Entities/Category.php';

use App\Domain\Entities\Category;

class CategoryRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findById(int $id): ?Category
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Category(id: $data['id'], name: $data['name'], created_at: $data['created_at'], updated_at: $data['updated_at']) : null;
    }

    public function findByName(string $name): ?Category
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE name LIKE ?');
        $stmt->execute(['%' . $name . '%']);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Category(id: $data['id'], name: $data['name'], created_at: $data['created_at'], updated_at: $data['updated_at']) : null;
    }


    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM categories');
        $categories = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category(id: $data['id'], name: $data['name'], created_at: $data['created_at'], updated_at: $data['updated_at']);
        }
        return $categories;
    }

    public function save(Category $category): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO categories (name) VALUES (:name)');
        $stmt->execute(['name' => $category->getName()]);
    }
}
