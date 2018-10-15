<?php
/**
 * Shows interesting movies.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Show all movies.
 */
$app->router->get("movie", function () use ($app) {
    $mdb = new \Guni\Movie\Movies($app);
    $res = $mdb->getAll();
    return $app->page->render();
});


/**
 * Search production year for a movie
 */
$app->router->get("movie/searchy", function () use ($app) {
    $mdb = new \Guni\Movie\Movies($app);
    $mdb->getYearSearch();
    return $app->page->render();
});


/**
 * Search title of a movie
 */
$app->router->get("movie/searcht", function () use ($app) {
    $mdb = new \Guni\Movie\Movies($app);
    $mdb->getTitleSearch();
    return $app->page->render();
});



/**
 * CRUD functions for the movies
 */
$app->router->any("GET|POST", "movie/select", function () use ($app) {
    $mdb = new \Guni\Movie\Movies($app);
    $mdb->getCrud();
    return $app->page->render();
});


/**
 * Reset all the movies
 */
$app->router->any("GET|POST", "movie/reset", function () use ($app) {
    $mdb = new \Guni\Movie\MoviesExtra($app);
    $mdb->doReset();
    return $app->page->render();
});


/**
 * Paginate the movies
 */
$app->router->any("GET|POST", "movie/paginate", function () use ($app) {
    $mdb = new \Guni\Movie\MoviesExtra($app);
    $mdb->getAllPaginated();
    return $app->page->render();
});


/**
 * Paginate the movies
 */
$app->router->any("GET|POST", "movie/paginate/{id:digit}", function () use ($app) {
    $parts = $app->router->getMatchedPath();
    $arr = explode("/", $parts);
    $mdb = new \Guni\Movie\MoviesExtra($app);
    $mdb->getAllPaginated($arr[2]);
    return $app->page->render();
});


/**
 * Paginate the movies
 */
$app->router->any("GET|POST", "movie/paginate/{id:digit/{id:digit}", function () use ($app) {
    $parts = $app->router->getMatchedPath();
    $arr = explode("/", $parts);
    $mdb = new \Guni\Movie\MoviesExtra($app);
    $mdb->getAllPaginated($arr[2], $arr[3]);
    return $app->page->render();
});
