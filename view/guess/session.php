<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>
    <h1><?= $title ?></h1>
    <p></p>
    <body>
    <form method="POST">
        <input type="text" name="guess" autofocus="" value="">

        <input type="submit" name="doGuess" value="Make a Guess">
        <input type="submit" name="doCheat" value="Cheat">
        <input type="submit" name="doReset" value="Reset the game">
    </form>
    <p><?= $cheat ?></p>
    <p><?= $res ?></p>
    