<?php
/**
 * Hundred game.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Play dice game Hundred
 */
$app->router->any(["GET", "POST"], "hundra/play", function () use ($app) {

    //Our memebers
    $players = [];

    $starter = "";
    $message = "";

    $res = null;
    $score = null;
    $player = null;


    //Start with player name and create the players
    $name = $_SESSION['name'] ?? $_POST['name'] ?? null;
    $dices = $_SESSION['dices'] ?? $_POST['dices'] ?? 0;
    if (!$name) {
        $starter = "Write your name before we start.";
    }

    if (isset($_POST["save"])) {
        if ($name) {
            if ($dices) {
                if (!isset($_SESSION["dices"])) {
                    $_SESSION["dices"] = $dices;
                }
            }

            $newgame = new Guni\Hundred\Player($name, $dices);
            if (!isset($_SESSION["player"])) {
                $_SESSION["player"] = $newgame;
            }

            if (!isset($_SESSION["name"])) {
                $_SESSION["name"] = $name;
            }

            $computer = new Guni\Hundred\Player("Computer", $dices);
            if (!isset($_SESSION["computer"])) {
                $_SESSION["computer"] = $computer;
            }

            $nowplaying = [$newgame, $computer];
            $players = new Guni\Hundred\Hundred($nowplaying, $dices);
            if (!isset($_SESSION["players"])) {
                $_SESSION["players"] = $players;
            }
        } else {
            $starter = "Write your name before we start.";
        }
    }


    $player = $_SESSION && $_SESSION["player"] ? $_SESSION["player"] : null;
    $computer = $_SESSION && $_SESSION["computer"] ? $_SESSION["computer"] : null;
    $name = $_SESSION && $_SESSION["name"] ? $_SESSION["name"] : null;
    $players = $_SESSION && $_SESSION["players"] ? $_SESSION["players"] : null;
    $dices = $_SESSION && $_SESSION["dices"] ? $_SESSION["dices"] : 0;
    //var_dump($_SESSION);
    //var_dump($dices);


    //Roll the dice
    if (isset($_POST["start"])) {
        if ($player) {
            $starter = $players->rollToStart();
        } else {
            $starter = "We need your username for the game to start.";
        }
    }


    //Roll the dice
    if (isset($_POST["doPlay"])) {
        if ($player) {
            $starter = $players->playButton($name);
            $message = $player->getMessage() . "<br/ >" . $computer->getMessage();
        } else {
            $starter = "You need to be someone to play the game.";
        }
        //var_dump($players->getDetails());
    }

    //Save the roll
    if (isset($_POST["keepRoll"])) {
        if ($player) {
            if ($player->getTemp() > 1) {
                $starter .= $player->play();
                $computer->setCurrentPlayer();
            }
            $message = $player->getMessage() . "<br/ >" . $computer->getMessage();
        } else {
            $starter = "There is noone yet to play the game.";
        }
    }


    //Reset the game
    if (isset($_POST["reset"])) {
        if ($player) {
            $players->reset();
        }

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
        $name = "";
        echo "The session is destroyed.";
    }


    //var_dump($players);


    //Prepare $data

    $nametext = $name ? " " . $name : "";
    $data = [
        "title" => "Welcome" . $nametext . "!<br /> Ready to play hundred?",
    ];
    $data["name"] = $name;
    $data["message"] = $message;
    $data["res"] = $res;
    $data["starter"] = $starter;


    //Add view and render page
    $app->page->add("hundred/play", $data);
    return $app->page->render();
});
