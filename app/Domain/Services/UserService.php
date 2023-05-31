<?php

namespace App\Domain\Services;

require_once __DIR__ . '/../../Repositories/UserRepository.php';
require_once __DIR__ . '/../../Repositories/RoleRepository.php';
require_once __DIR__ . '/../../Domain/Entities/User.php';
require_once __DIR__ . '/../../Domain/ValueObjects/Email.php';


use App\Domain\Entities\User;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Domain\ValueObjects\Email;

class UserService
{
    protected $userRepository;
    protected $roleRepository;



    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->roleRepository = new RoleRepository();
    }

    public function createUser(string $username, Email $email, string $password, string $roleName)
    {
        // Vérification que le rôle existe
        $role = $this->roleRepository->findByName($roleName);
        if (!$role) {
            throw new \Exception("Le rôle n'existe pas.");
        }


        // Création de l'utilisateur
        $user = new User(name: $username, email: $email, password: password_hash($password, PASSWORD_DEFAULT));
        $user->setRole($role);

        // Enregistrement en base de données
        $this->userRepository->save($user);

        return $user;
    }

    public function getUserByEmail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            $role = $this->roleRepository->findById($user->getRole()->getId());
            $user->setRole($role);
        }
        return $user;
    }
}
