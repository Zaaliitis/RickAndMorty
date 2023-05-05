<?php

namespace App;

use GuzzleHttp\Client;
use App\Models\Character;
use App\Models\Episode;
use App\Models\Location;
use stdClass;

class ApiClient
{
    private Client $client;
    private array $characterCollection = [];
    private array $episodeCollection = [];
    private array $locationCollection = [];

    public function __construct()
    {
        $this->client = new Client([
                'base_uri' => 'https://rickandmortyapi.com/api/'
            ]
        );
    }

    public function getCharacters($page = 1): array
    {
        $response = $this->client->get('character', ['query' => ['page' => $page]]);
        return $this->characterCollection(json_decode($response->getBody()->getContents())->results);
    }

    public function getLocations(): array
    {
        $results = [];
        for ($page = 1; $page <= 7; $page++) {
            $response = $this->client->get('location', ['query' => ['page' => $page]]);
            $results = array_merge($results, $this->locationCollection(json_decode($response->getBody()->getContents())->results));
        }
        return $results;
    }

    public function getEpisodes(): array
    {
        $results = [];

        for ($page = 1; $page <= 3; $page++) {
            $response = $this->client->get('episode', ['query' => ['page' => $page]]);
            $results = array_merge($results, $this->episodeCollection(json_decode($response->getBody()->getContents())->results));
        }

        return $results;
    }


    private function characterCollection($characters): array
    {
        foreach ($characters as $character) {
            $this->characterCollection[] = $this->createCharacter($character);
        }
        return $this->characterCollection;
    }

    private function createCharacter(stdClass $character): Character
    {
        return new Character(
            $character->name,
            $character->status,
            $character->species,
            $character->gender,
            $character->location->name,
            $character->location->url,
            $character->image,
            $character->episode[0],
            $character->url
        );
    }

    private function episodeCollection($episodes): array
    {
        foreach ($episodes as $episode) {
            $this->episodeCollection[] = $this->createEpisode($episode);
        }
        return $this->episodeCollection;
    }

    private function createEpisode(stdClass $episode): Episode
    {
        return new Episode(
            $episode->url,
            $episode->name,
            $episode->episode,
            $episode->characters
        );
    }

    private function locationCollection($locations): array
    {
        foreach ($locations as $location) {
            $this->locationCollection[] = $this->createLocation($location);
        }
        return $this->locationCollection;
    }

    private function createLocation(stdClass $location): Location
    {
        return new Location(
            $location->name,
            $location->type,
            $location->dimension,
            $location->residents,
            $location->url
        );
    }
}