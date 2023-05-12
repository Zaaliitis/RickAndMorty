<?php

namespace App;

use App\Core\Cache;
use App\Models\Character;
use App\Models\Episode;
use App\Models\Location;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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

    public function getCharacters(int $page = 1): array
    {
        if (!Cache::has('characters_' . $page)) {
            $response = $this->client->get('character', ['query' => ['page' => $page]]);
            $responseContents = $response->getBody()->getContents();
            Cache::remember('characters_' . $page, $responseContents);
        } else {
            $responseContents = Cache::get('characters_' . $page);
        }

        return $this->characterCollection(json_decode($responseContents)->results);
    }

    public function getCharactersByName(string $name, int $page): array
    {
        try {
            if (!Cache::has('characters_' . $name . $page)) {
                $response = $this->client->get('character', ['query' => ['name' => $name, 'page' => $page]]);
                $responseContents = $response->getBody()->getContents();
                Cache::remember('characters_' . $name . $page, $responseContents);
            } else {
                $responseContents = Cache::get('characters_' . $name . $page);
            }

            return $this->characterCollection(json_decode($responseContents)->results);
        } catch (RequestException $e) {
            return [];
        }

    }

    public function getCharacter(int $id): ?Character
    {
        try {
            if (!Cache::has('character_' . $id)) {
                $response = $this->client->get('character/' . $id);
                $responseContents = $response->getBody()->getContents();
                Cache::remember('character_' . $id, $responseContents);
            } else {
                $responseContents = Cache::get('character_' . $id);
            }
            return $this->createCharacter(json_decode($responseContents));
        } catch (RequestException $e) {
            return null;
        }
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
        $episodeNames = $this->getEpisodeNames($character->episode);
        $firstEpisodeID = basename($character->episode[0]);
        if (!Cache::has('episode_' . $firstEpisodeID)) {
            $episodeContents = $this->client->get($character->episode[0])->getBody()->getContents();
            Cache::remember('episode_' . $firstEpisodeID, $episodeContents);
        } else {
            $episodeContents = Cache::get('episode_' . $firstEpisodeID);
        }
        $episode = json_decode($episodeContents);

        return new Character(
            $character->id,
            $character->name,
            $character->status,
            $character->species,
            $character->gender,
            $character->location->name,
            $character->location->url,
            $character->image,
            new Episode(
                $episode->id,
                $episode->url,
                $episode->name,
                $episode->episode,
                $episode->characters),
            $episodeNames,
            $character->url
        );
    }

    private function getEpisodeNames(array $episodeUrls): array
    {
        $episodes = [];
        foreach ($episodeUrls as $episodeUrl) {
            $episodeID = basename($episodeUrl);
            if (!Cache::has('episode_' . $episodeID)) {
                $episodeResponse = $this->client->get($episodeUrl);
                $episodeContents = $episodeResponse->getBody()->getContents();
                Cache::remember('episode_' . $episodeID, $episodeContents);
            } else {
                $episodeContents = Cache::get('episode_' . $episodeID);
            }
            $episode = json_decode($episodeContents);
            $episodes[] = [
                'name' => $episode->name,
                'number' => $episode->episode
            ];
        }
        return $episodes;
    }

    public function getEpisodes(): array
    {
        $results = [];

        for ($page = 1; $page <= 3; $page++) {
            if (!Cache::has('episodes_' . $page)) {
                $response = $this->client->get('episode', ['query' => ['page' => $page]]);
                $responseContent = $response->getBody()->getContents();
                Cache::remember('episodes_' . $page, $responseContent);
            } else {
                $responseContent = Cache::get('episodes_' . $page);
            }
            $results = array_merge($results, $this->episodeCollection(json_decode($responseContent)->results));

        }

        return $results;
    }

    public function getEpisode(int $id): ?Episode
    {
        $response = $this->client->get('episode/' . $id);
        $episodeContent = json_decode($response->getBody()->getContents());
        return $this->createEpisode($episodeContent);
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
        $characters = [];

        foreach ($episode->characters as $characterUrl) {
            $characterId = basename($characterUrl);
            $character = $this->getCharacter($characterId);
            $characters[] = $character->getName();
        }
        return new Episode(
            $episode->id,
            $episode->url,
            $episode->name,
            $episode->episode,
            $characters
        );
    }

    public function getLocations(): array
    {

        $results = [];
        for ($page = 1; $page <= 7; $page++) {
            if (!Cache::has('location_' . $page)) {
                $response = $this->client->get('location', ['query' => ['page' => $page]]);
                $responseContents = $response->getBody()->getContents();
                Cache::remember('location_' . $page, $responseContents);
            } else {
                $responseContents = Cache::get('location_' . $page);
            }
            $results = array_merge($results, $this->locationCollection(json_decode($responseContents)->results));
        }
        return $results;
    }

    public function getLocation(int $id): ?Location
    {
        $response = $this->client->get('location/' . $id);
        $locationContent = json_decode($response->getBody()->getContents());
        return $this->createLocation($locationContent);
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
        $residents = [];

        foreach ($location->residents as $residentUrl) {
            $residentId = basename($residentUrl);
            $resident = $this->getCharacter($residentId);
            $residents[] = $resident->getName();
        }
        return new Location(
            $location->id,
            $location->name,
            $location->type,
            $location->dimension,
            $residents,
            $location->url
        );
    }
}