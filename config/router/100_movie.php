<?php

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Route\Exception\NotFoundException;

/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "movie",

    // All routes in order
    "routes" => [
        [
            "info" => "Movie controller.",
            "mount" => "",
            "handler" => "\Guni\Movie\MovieController",
        ],
    ]
];
