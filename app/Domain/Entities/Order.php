<?php

namespace App\Domain\Entities;

use DateTime;

class Order
{
    private int $id;

    private ?User $customer;

    private int $amount;

    private string $status;

    private string $shipping_address;

    private ?Product $product;

    private int $quantity;

    /** @var DateTime */
    private $created_at;

    /** @var DateTime */
    private $updated_at;

    private string $ordered_at;

    public function __construct(...$args)
    {
        $this->id = $args['id'] ?? 0;
        $this->amount = $args['amount'] ?? 0;
        $this->status = $args['status'] ?? '';
        $this->shipping_address = $args['shipping_address'] ?? '';
        $this->quantity = $args['quantity'] ?? 0;
        $this->customer = $args['customer'];
        $this->product = $args['product'];
        $this->created_at = $args['created_at'];
        $this->updated_at = $args['updated_at'];
        $this->ordered_at = $args['ordered_at'] ?? '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomer(): User
    {
        return $this->customer;
    }

    public function getShippingaddress(): string
    {
        return $this->shipping_address;
    }

    public function getOrderdate(): ?string
    {
        return $this->ordered_at;
    }

    // pending | processing | completed
    public function getStatus(): string
    {
        return $this->status;
    }
    public function getQuantity(): string
    {
        return $this->quantity;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }


    public function getProduct(): Product
    {
        return $this->product;
    }
}
