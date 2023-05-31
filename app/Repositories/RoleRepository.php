<?php

namespace App\Repositories;

use PDO;
use Core\Database;

require_once __DIR__ . '/../Domain/Entities/Role.php';

use App\Domain\Entities\Role;

class RoleRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findById(int $id): ?Role
    {
        $stmt = $this->pdo->prepare('SELECT * FROM roles WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Role(id: $data['id'], name: $data['name'], created_at: $data['created_at'], updated_at: $data['updated_at']) : null;
    }

    public function findByName(string $name): ?Role
    {
        $stmt = $this->pdo->prepare('SELECT * FROM roles WHERE name = ?');
        $stmt->execute([$name]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Role(id: $data['id'], name: $data['name']) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM roles');
        $roles = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $roles[] = new Role(id: $data['id'], name: $data['name']);
        }
        return $roles;
    }

    public function save(Role $role): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO roles (name) VALUES (:name)');
        $stmt->execute(['name' => $role->getName()]);
    }
}
