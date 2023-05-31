<?php

namespace App\Domain\Aggregates;

use App\Domain\Entities\Product;
use App\Domain\Entities\User;

class StockAggregate
{
    private $product;
    private $supplier;
    private $quantity;

    public function __construct(Product $product, User $supplier, int $quantity)
    {
        $this->product = $product;
        $this->supplier = $supplier;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getSupplier(): User
    {
        return $this->supplier;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(int $amount)
    {
        $this->quantity += $amount;
    }

    public function decreaseQuantity(int $amount)
    {
        $this->quantity -= $amount;
        if ($this->quantity < 0) {
            $this->quantity = 0;
        }
    }
}
