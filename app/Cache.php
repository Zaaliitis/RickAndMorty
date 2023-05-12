<?php

namespace App;

use Carbon\Carbon;

class Cache
{
    private static string $cacheDir = '../Cache/';

    public static function remember(string $key, string $data, int $ttl = 600): void
    {
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir);
        }
        $cacheFile = self::$cacheDir . $key;
        file_put_contents($cacheFile, json_encode([
            'expires_at' => Carbon::now('GMT+2')->addSeconds($ttl),
            'content' => $data
        ]));
    }

    public static function forget(string $key): void
    {
        unlink(self::$cacheDir . $key);
    }

    public static function get(string $key): ?string
    {
        if (!self::has($key))
        {
            return null;
        }
        $content = json_decode(file_get_contents(self::$cacheDir . $key));
        return $content->content;
    }

    public static function has(string $key): bool
    {
        if (!file_exists(self::$cacheDir . $key))
        {
            return false;
        }
        $content = json_decode(file_get_contents(self::$cacheDir . $key));
        return Carbon::now('GMT+2') < $content->expires_at;
    }

}