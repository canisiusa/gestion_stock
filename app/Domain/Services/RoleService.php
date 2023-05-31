<?php

namespace App\Domain\Services;

require_once __DIR__ . '/../../Repositories/RoleRepository.php';


use App\Repositories\RoleRepository;

class RoleService
{
    protected $roleRepository;

    public function __construct()
    {
        $this->roleRepository = new RoleRepository();
    }

    public function getRole($id)
    {
        $role = $this->roleRepository->findById($id);
        return $role;
    }
}
