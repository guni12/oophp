<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$res = $res ?? null;

$session = $this->di->get("session");
$isloggedin = $session->get("user");

$buttonDelete = '<button type="submit" name="doDeleteForever"><i class="fa fa-trash-o" aria-hidden="true"></i> Avsluta permanent</button>';

$deleteForSure = $isloggedin && $isloggedin["userId"] == 2 ? $buttonDelete : null;


if (!$res) {
    return;
}

?>
<h1><?= $title ?></h1>

<form method="post">
    <fieldset>
    <legend>Ta bort medlem</legend>

    <input type="hidden" name="userId" value="<?= esc($res->userid) ?>"/>

    <p>
        <label>Användare:<br> 
            <input type="text" name="userName" value="<?= esc($res->user) ?>" readonly/>
        </label>
    </p>

    <p>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Avsluta</button>
        <?= $deleteForSure ?>
    </p>
    </fieldset>
</form>
