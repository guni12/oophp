<?php

namespace Guni\Guess;

/**
* Guess my number med get
*/
include(__DIR__ . "/config.php");
//include(__DIR__ . "/autoload.php");
include(__DIR__ . "/../../vendor/autoload.php");

//For the view
$title = "Guess my number (GET)";

//Get incoming
$number = $_GET["number"] ?? -1;
$tries = $_GET["tries"] ?? 6;
$guess = $_GET["guess"] ?? null;

//Start the game
$game = new Guess($number, $tries);

//Reset the game
if (isset($_GET["reset"])) {
    $game->random();
}

//Do a guess
$res = null;
try {
    if (isset($_GET["doGuess"])) {
        $res = $game->makeGuess($guess);
    }
} catch (GuessException $e) {
    echo "Got exception: " . get_class($e) . "<hr>";
    $res = "Number must be between 1 and 100.";
}

//Cheat
$cheat = null;
if (isset($_GET["doCheat"])) {
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
    <form method="GET">
        <input type="hidden" name="number" value="<?= $game->number() ?>">
        <input type="hidden" name="tries" value="<?= $game->tries() ?>">
        <input type="text" name="guess" autofocus="" value="">

        <input type="submit" name="doGuess" value="Make a Guess">
        <input type="submit" name="doCheat" value="Cheat">
        <input type="submit" name="reset" value="Reset the game">
    </form>
    <p><?= $cheat ?></p>
    <p><?= $res ?></p>
</body>
</html>
