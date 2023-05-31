<?php

namespace App\Domain\Entities;

class Category
{
    private int $id;

    private string $name;

    /** @var DateTime */
    private $created_at;

    /** @var DateTime */
    private $updated_at;

    public function __construct(...$args)
    {
        $this->id = $args['id'] ?? 0;
        $this->name = $args['name'] ?? '';
        $this->created_at = $args['created_at'];
        $this->updated_at = $args['updated_at'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
