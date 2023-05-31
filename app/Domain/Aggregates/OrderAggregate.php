<?php

namespace App\Domain\Aggregates;

use App\Domain\Entities\Product;
use App\Domain\Entities\User;
use App\Domain\ValueObjects\Address;

class OrderAggregate
{
    private $products;
    private $customer;
    private $shippingAddress;

    public function __construct(User $customer, Address $shippingAddress)
    {
        $this->customer = $customer;
        $this->shippingAddress = $shippingAddress;
        $this->products = [];
    }

    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    public function removeProduct(Product $product)
    {
        $index = array_search($product, $this->products);
        if ($index !== false) {
            unset($this->products[$index]);
        }
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice();
        }
        return $total;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }
}
