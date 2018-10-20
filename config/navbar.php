<?php
/**
 * Supply the basis for the navbar as an array.
 */
$isloggedin = isset($_SESSION["user"]) ? "Medlem" : "Login";
//var_dump($isadmin, $_SESSION["user"]["id"]);
$adminNav = ["text" => "Admin","url" => "admin","title" => "Admin",];
$showAdmin = isset($_SESSION["user"]) && $_SESSION["user"]["userId"] == 2 ? $adminNav : null;
return [
    [
        "text" => "Hem",
        "url" => "",
        "title" => "Första sidan, börja här.",
    ],
    [
        "text" => "Redovisning",
        "url" => "redovisning",
        "title" => "Redovisningstexter från kursmomenten.",
    ],
    [
        "text" => "Om",
        "url" => "om",
        "title" => "Om denna webbplats.",
    ],
    /*[
        "text" => "Lek",
        "url" => "lek",
        "title" => "Lek runt och testa att integrera kod i me-sidan.",
    ],*/
    [
        "text" => "Dev",
        "url" => "dev",
        "title" => "Anax development and debugging utilities.",
    ],
    /*
    [
        "text" => "Test",
        "url" => "test",
        "title" => "Anax test page for routes.",
    ],*/
    [
        "text" => "Gissa",
        "url" => "gissa",
        "title" => "Gissa-lek.",
    ],
    [
        "text" => "Hundra",
        "url" => "hundred",
        "title" => "Tärningsspel",
    ],
    [
        "text" => "Movie",
        "url" => "movie",
        "title" => "Filmer",
    ],
    [
        "text" => "Filter",
        "url" => "filter",
        "title" => "Filter",
    ],
    [
        "text" => "Blog",
        "url" => "post",
        "title" => "Blog",
    ],
    [
        "text" => "Sidor",
        "url" => "page",
        "title" => "Sidor",
    ],
    [
        "text" => $isloggedin,
        "url" => "user/login",
        "title" => "Login",
    ],
    $showAdmin,
];
