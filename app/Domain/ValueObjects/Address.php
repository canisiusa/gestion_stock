<?php

namespace App\Domain\ValueObjects;

class Address
{
    private string $street;
    private string $city;
    private string $state;
    private string $zip;

    public function __construct(string $street, string $city, string $state, string $zip)
    {
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zip = $zip;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function __toString(): string
    {
        return sprintf("%s, %s, %s %s", $this->street, $this->city, $this->state, $this->zip);
    }
}
