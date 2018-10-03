<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

    <h1><?= $title ?></h1>

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
