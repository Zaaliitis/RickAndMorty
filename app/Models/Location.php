<?php

namespace App\Models;

use App\ApiClient;

class Location
{
    private int $id;
    private string $name;
    private string $type;
    private string $dimension;
    private array $residents;
    private string $url;

    public function __construct(
        int    $id,
        string $name,
        string $type,
        string $dimension,
        array  $residents,
        string $url
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->dimension = $dimension;
        $this->residents = $residents;
        $this->url = $url;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getDimension(): string
    {
        return $this->dimension;
    }


    public function getResidents(): array
    {
        return $this->residents;
    }


    public function getType(): string
    {
        return $this->type;
    }
}