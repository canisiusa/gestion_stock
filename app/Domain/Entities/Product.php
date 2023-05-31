<?php

namespace App\Domain\Entities;

class Product
{

    private int $id;

    private string $name;

    private string $image;

    private ?string $description;

    private float $price;

    private int $quantity;

    private ?Category $category;

    private ?User $supplier;

    /** @var DateTime */
    private $created_at;

    /** @var DateTime */
    private $updated_at;

    /** @var DateTime */
    private $deleted_at;

    public function __construct(...$args)
    {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->description = $args['description'];
        $this->price = $args['price'] ?? 0.0;
        $this->quantity = $args['quantity'] ?? 0;
        $this->category = $args['category'];
        $this->supplier = $args['supplier'];
        $this->created_at = $args['created_at'];
        $this->updated_at = $args['updated_at'];
        $this->deleted_at = $args['deleted_at'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getSupplier(): User
    {
        return $this->supplier;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    public function setSupplier(User $supplier)
    {
        $this->supplier = $supplier;
    }
}
