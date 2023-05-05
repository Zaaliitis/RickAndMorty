<?php

namespace App\Models;

use App\ApiClient;

class Episode
{
    private string $url;
    private string $episodeName;
    private string $episodeNumber;
    private array $characters;
    private ApiClient $client;

    public function __construct(
        string $url,
        string $episodeName,
        string $episodeNumber,
        array  $characters
    )
    {
        $this->url = $url;
        $this->episodeNumber = $episodeNumber;
        $this->episodeName = $episodeName;
        $this->characters = $characters;
        $this->client = new ApiClient();
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getEpisodeName(): string
    {
        return $this->episodeName;
    }

    public function getEpisodeNumber(): string
    {
        return $this->episodeNumber;
    }

    public function getCharacters(): array
    {
        $names = [];

        $characters = $this->client->getCharacters(1);
        foreach ($characters as $character) {
            /** @var Character $character */
            if (in_array($character->getUrl(), $this->characters)) {
                $names[] = $character->getName();
            }
        }

        if (empty($names)) {
            $names[] = "No one lives here";
        }

        return $names;
    }
}