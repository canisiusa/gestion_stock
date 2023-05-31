<?php

namespace App\Repositories;

use App\Domain\Entities\Role;
use PDO;
use Core\Database;

use App\Domain\Entities\User;

class UserRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new User(id: $data['id'], name: $data['name'], email: $data['email'], password: $data['password'], role: new Role(id:$data['role_id']) ) : null;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new User(id: $data['id'], name: $data['name'], email: $data['email'], password: $data['password'], role: new Role(id:$data['role_id']) ) : null;
    }


    public function countUsers($name): int
    {
        $query =  $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE name = ?");
        $query->execute([$name]);
        $count = $query->fetchColumn();
        return $count;
    }

    public function save(User $user): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)');
        $stmt->execute(['name' => $user->getName(), 'email' => $user->getEmail(), 'password' => $user->getPassword(), 'role_id' => $user->getRole()->getId()]);
    }
}
