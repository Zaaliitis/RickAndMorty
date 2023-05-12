<?php

namespace App\Models;

class Episode
{
    private int $id;
    private string $url;
    private string $episodeName;
    private string $episodeNumber;
    private array $characters;


    public function __construct(
        int $id,
        string $url,
        string $episodeName,
        string $episodeNumber,
        array  $characters
    )
    {
        $this->id = $id;
        $this->url = $url;
        $this->episodeNumber = $episodeNumber;
        $this->episodeName = $episodeName;
        $this->characters = $characters;
    }

    public function getId(): int
    {
        return $this->id;
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
        return $this->characters;

    }
}