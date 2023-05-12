<?php

namespace App\Models;


class Character
{
    private int $id;
    private string $name;
    private string $status;
    private string $species;
    private string $gender;
    private string $locationName;
    private string $locationUrl;
    private string $image;
    private Episode $firstEpisode;
    private string $url;
    private array $episodes;


    public function __construct(
        int $id,
        string  $name,
        string  $status,
        string  $species,
        string  $gender,
        string  $locationName,
        string  $locationUrl,
        string  $image,
        Episode $firstEpisode,
        array $episodes,
        string  $url
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->gender = $gender;
        $this->locationName = $locationName;
        $this->locationUrl = $locationUrl;
        $this->image = $image;
        $this->firstEpisode = $firstEpisode;
        $this->url = $url;
        $this->episodes = $episodes;
    }

    public function getEpisodes(): array
    {
        return $this->episodes;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getFirstEpisode(): Episode
    {
        return $this->firstEpisode;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getLocationName(): string
    {
        return $this->locationName;
    }

    public function getLocationUrl(): string
    {
        return $this->locationUrl;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}