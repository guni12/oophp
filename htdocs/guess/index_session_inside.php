<?php

namespace Guni\Guess;

/**
* Guess my number med session
*/
include(__DIR__ . "/config.php");
include(__DIR__ . "/../../vendor/autoload.php");

if (isset($_SESSION["game"])) {
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    echo "The session is destroyed.";
}

$newgame = new Guess();

session_name("guni12");
session_start();

//For the view
$title = "Guess my number (SESSION)";

if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = $newgame;
}

$game = $_SESSION["game"];
$number = $game->number();
$tries = $game->tries();

//Get incoming
$guess = $_POST["guess"] ?? null;

//Reset the game
if (isset($_POST["doReset"]) || isset($_GET["reset"])) {
    $game->random();
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
    echo "The session is destroyed.";
}

//Do a guess
$res = null;
if (isset($_POST["doGuess"])) {
    $res = $game->makeGuess($guess);
}

//Cheat
$cheat = null;
if (isset($_POST["doCheat"])) {
    $cheat = $number;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <h1><?= $title ?></h1>
    <p></p>
    <form method="POST">
        <input type="text" name="guess" autofocus="" value="">

        <input type="submit" name="doGuess" value="Make a Guess">
        <input type="submit" name="doCheat" value="Cheat">
        <input type="submit" name="doReset" value="Reset the game">
    </form>
    <p><?= $cheat ?></p>
    <p><?= $res ?></p>
</body>
</html>