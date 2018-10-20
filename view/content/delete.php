<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$res = $res ?? null;
$buttons = $buttons ?? null;

$req = $this->di->get("request");
$base = $req->getBaseUrl() . "/";
$link = $base . $res->type;

$session = $this->di->get("session");
$isloggedin = $session->get("user");

$buttonDelete = '<button type="submit" name="doDeleteForever"><i class="fa fa-trash-o" aria-hidden="true"></i> Kasta permanent</button>';

$deleteForSure = $isloggedin && $isloggedin["userId"] == 2 ? $buttonDelete : null;

if (!$res) {
    return;
}

?>
<form method="post">
    <fieldset>
    <legend>Kasta</legend>

    <input type="hidden" name="contentId" value="<?= esc($res->id) ?>"/>

    <p>
        <label>Title:<br> 
            <input type="text" name="contentTitle" value="<?= esc($res->title) ?>" readonly/>
        </label>
    </p>

    <p>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Kasta</button> | <?= $deleteForSure ?>
    </p>

    </fieldset>
</form>

<a href="<?= $link ?>"><button>Till alla</button></a>
