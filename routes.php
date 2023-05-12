<?php
return [
['GET', '/', [\App\Controllers\Controller::class, "home"]],
['GET', '/search', [\App\Controllers\Controller::class, "search"]],
['GET', '/character', [\App\Controllers\Controller::class, "character"]],
['GET', '/home', [\App\Controllers\Controller::class, "home"]],
['GET', '/location', [\App\Controllers\Controller::class, "location"]],
['GET', '/episode', [\App\Controllers\Controller::class, "episode"]]
];