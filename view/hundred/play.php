<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

    <h1><?= $title ?></h1>

    <form method="POST">
        <p>Start here:
        <input type="text" name="name" placeholder="Write your username" value="">
        <input list="nrofdices" name="dices" placeholder="Nr of dices">
        <datalist id="nrofdices">
            <option value="1">
            <option value="2">
            <option value="3">
            <option value="4">
            <option value="5">
        </datalist>
        <input type="submit" name="save" value="Save settings">
        <br /><br />
        <input type="submit" name="start" value="Highest roller begin">
        <br /><br /><?= $starter ?></p>
        <input type="submit" name="doPlay" value="Roll the Dice">
        <input type="submit" name="keepRoll" value="Save the Roll">
        <input type="submit" name="reset" value="Reset the game">
    </form>
    <p><?= $message ?></p>
    <p><?= $res ?></p>
