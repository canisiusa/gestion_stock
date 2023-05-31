<?php

namespace App\Domain\Entities;

class OldOrder
{
    private $id;
    private $customer;
    private $products;

    public function __construct(string $id, User $customer, array $products = [])
    {
        $this->id = $id;
        $this->customer = $customer;
        $this->products = $products;
    }

    public function getOrderId(): string
    {
        return $this->id;
    }

    public function getCustomerName(): User
    {
        return $this->customer;
    }

    public function addProduct(Product $product, int $quantity)
    {
        $this->products[$product->getId()] = $quantity;
    }

    public function removeProduct(Product $product)
    {
        $productId = $product->getId();
        if (isset($this->products[$productId])) {
            unset($this->products[$productId]);
        }
    }

    public function getProducts(): array
    {
        return $this->products;
    }
}
