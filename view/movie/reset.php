<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$output = $output ?? null;
$buttons = $buttons ?? null;
/*
if (!$output) {
    return;
}*/

$req = $this->di->get("request");
$base = $req->getBaseUrl();
$link = $base . "/movie";

?>
<h1><?= $title ?></h1>

<?= $buttons ?>
<br /><br />
<form method="post">
    <input type="submit" name="reset" value="Återställ databasen">
    <input type="submit" name="resetbth" value="Återställ BTH">
    <?= $output ?>
</form>
<br /><br />
<a href="<?= $link ?>"><button>Visa alla</button></a>
