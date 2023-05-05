<?php

namespace App\Models;

use App\ApiClient;

class Character
{
    private string $name;
    private string $status;
    private string $species;
    private string $gender;
    private string $locationName;
    private string $locationUrl;
    private string $image;
    private string $firstEpisode;
    private string $url;
    private ApiClient $client;

    public function __construct(
        string $name,
        string $status,
        string $species,
        string $gender,
        string $locationName,
        string $locationUrl,
        string $image,
        string $firstEpisode,
        string $url
    )
    {
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->gender = $gender;
        $this->locationName = $locationName;
        $this->locationUrl = $locationUrl;
        $this->image = $image;
        $this->firstEpisode = $firstEpisode;
        $this->url = $url;
        $this->client = new ApiClient();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFirstEpisode(): string
    {
        $episodes = $this->client->getEpisodes();
        foreach ($episodes as $episode) {
            /** @var Episode $episode */
            $url = $episode->getUrl();
            if ($url === $this->firstEpisode) {
                return $episode->getEpisodeName();
            }
        }
        return "Unknown episode";
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