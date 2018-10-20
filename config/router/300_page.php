<?php

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\InternalErrorException;
use Anax\Route\Exception\NotFoundException;

/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.
    "mount" => "page",

    // All routes in order
    "routes" => [
        [
            "info" => "Page controller.",
            "mount" => "",
            "handler" => "\Guni\Content\PageController",
        ],
    ]
];
