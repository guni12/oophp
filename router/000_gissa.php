<?php
/**
 * Guess game.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Guess my number with get.
 */
$app->router->get("gissa/get", function () use ($app) {
    //include __DIR__ . "/../htdocs/guess/index_get_inside.php";

    $data = [
        "title" => "Guess my number (GET)",
    ];

    //Get incoming
    $number = $_GET["number"] ?? -1;
    $tries = $_GET["tries"] ?? 6;
    $guess = $_GET["guess"] ?? null;

    //Start the game
    $game = new Guni\Guess\Guess($number, $tries);

    //Reset the game
    if (isset($_GET["reset"])) {
        $game->random();
    }

    //Do a guess
    $res = null;
    if (isset($_GET["doGuess"])) {
        try {
            $res = $game->makeGuess($guess);
        } catch (Guni\Guess\GuessException $e) {
            $res = "Got exception: " . get_class($e) . "<hr>";
            $res .= "Number must be between 1 and 100.";
        }
    }


    //Return cheat content
    $cheat = null;
    if (isset($_GET["doCheat"])) {
        $cheat = $number;
    }

    //Prepare $data
    $data["game"] = $game;
    $data["res"] = $res;
    $data["cheat"] = $cheat;
    $data["guess"] = $guess;
    $data["number"] = $number;
    $data["tries"] = $tries;

    //Add view and render page
    $app->page->add("guess/get", $data);
    return $app->page->render();
});



/**
 * Guess my number with post.
 */
$app->router->any(["GET", "POST"], "gissa/post", function () use ($app) {
    //include __DIR__ . "/../htdocs/guess/index_get_inside.php";

    $data = [
        "title" => "Guess my number (POST)",
    ];

    //Get incoming
    $number = $_POST["number"] ?? -1;
    $tries = $_POST["tries"] ?? 6;
    $guess = $_POST["guess"] ?? null;

    //Start the game
    $game = new Guni\Guess\Guess($number, $tries);

    //Reset the game
    if (isset($_POST["doReset"])) {
        $game->random();
    }

    //Do a guess
    $res = null;
    try {
        if (isset($_POST["doGuess"])) {
            $res = $game->makeGuess($guess);
        }
    } catch (GuessException $e) {
        echo "Got exception: " . get_class($e) . "<hr>";
        $res = "Number must be between 1 and 100.";
    }

    //Return cheat content
    $cheat = null;
    if (isset($_POST["doCheat"])) {
        $cheat = $number;
    }

    //Prepare $data
    $data["game"] = $game;
    $data["res"] = $res;
    $data["cheat"] = $cheat;
    $data["guess"] = $guess;
    $data["number"] = $number;
    $data["tries"] = $tries;

    //Add view and render page
    $app->page->add("guess/post", $data);
    return $app->page->render();
});





/**
 * Guess my number with session.
 */
$app->router->any(["GET", "POST"], "gissa/session", function () use ($app) {
    /*
    // Show all routes
    echo "ALL ROUTES\n";
    echo "<br />";
    foreach ($app->router->getAll() as $route) {
        echo $route->getAbsolutePath() . " : ";
        echo $route->getRequestMethod() . " : ";
        echo $route->getInfo() . "\n";
        echo "<br />";
    }*/

    $data = [
        "title" => "Guess my number (SESSION)",
    ];

    $newgame = new Guni\Guess\Guess();

    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = $newgame;
    }
    $game = $_SESSION["game"];


    $number = $game->number();
    $tries = $game->tries();
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
    try {
        if (isset($_POST["doGuess"])) {
            echo "Ja";
            $res = $game->makeGuess($guess);
        }
    } catch (GuessException $e) {
        echo "Got exception: " . get_class($e) . "<hr>";
        $res = "Number must be between 1 and 100.";
    }

    //Cheat
    $cheat = null;
    if (isset($_POST["doCheat"])) {
        $cheat = $number;
    }

    //Prepare $data
    $data["game"] = $game;
    $data["res"] = $res;
    $data["cheat"] = $cheat;

    //Add view and render page
    $app->view->add("guess/session", $data);
    return $app->page->render($data);
});
