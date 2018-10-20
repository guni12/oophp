<?php
/**
 * Shows interesting movies.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Show all movies.
 */
$app->router->get("logout", function () use ($app) {
    $class = new \Guni\User\User($app);
    $res = $class->logout();
});
