<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Address;

class User
{
    private int $id;

    private string $name;

    private string $email;

    private ?Address $address;

    private string $phone;

    private string $password;

    private ?Role $role;

    /** @var DateTime */
    private $created_at;

    /** @var DateTime */
    private $updated_at;

    public function __construct(...$args)
    {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->role = $args['role'];
        $this->address = $args['address'];
        $this->phone = $args['phone'] ?? '';
        $this->created_at = $args['created_at'];
        $this->updated_at = $args['updated_at'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    // mot de passe hashé
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    public function setAddress(Email $address)
    {
        $this->address = $address;
    }

    public function setRole(Role $role)
    {
        $this->role = $role;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }
}
