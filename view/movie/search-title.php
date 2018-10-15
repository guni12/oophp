<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$buttons = $buttons ?? null;

$req = $this->di->get("request");
$base = $req->getBaseUrl();
$movie = $base . "/movie";

?>
<h1><?= $title ?></h1>

<?= $buttons ?>

<form method="get">
    <fieldset>
    <legend>Sök</legend>
    <input type="hidden" name="route" value="search-title">
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value=""/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Sök">
    </p>
    </fieldset>
</form>
<a href="<?= $movie ?>"><button>Visa alla</button></a>
