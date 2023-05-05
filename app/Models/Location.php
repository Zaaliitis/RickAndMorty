<?php

namespace App\Models;
use App\ApiClient;

class Location
{
    private string $name;
    private string $type;
    private string $dimension;
    private array $residents;
    private string $url;
    private ApiClient $client;

    public function __construct(string $name, string $type, string $dimension, array $residents, string $url)
    {
        $this->name = $name;
        $this->type = $type;
        $this->dimension = $dimension;
        $this->residents = $residents;
        $this->url = $url;
        $this->client = new ApiClient();
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
        $names = [];

        $characters = $this->client->getCharacters(1);
        foreach ($characters as $character) {
            /** @var Character $character */
            if (in_array($character->getUrl(), $this->residents)) {
                $names[] = $character->getName();
            }
        }

        if (empty($names)) {
            $names[] = "No one lives here";
        }

        return $names;
    }


    public function getType(): string
    {
        return $this->type;
    }
}