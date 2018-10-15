<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$buttons = $buttons ?? null;
$year1 = $year1 ?? null;
$year2 = $year2 ?? null;

$req = $this->di->get("request");
$base = $req->getBaseUrl();
$movie = $base . "/movie";

?>
<h1><?= $title ?></h1>

<?= $buttons ?>

<form method="get">
    <fieldset>
    <legend>Sök filmer</legend>
    <input type="hidden" name="route" value="search-year">
    <p>
        <label>Producerad mellan: 
        <input type="number" name="year1" value="<?= $year1 ?: 1900 ?>" min="1900" max="2100"/>
        - 
        <input type="number" name="year2" value="<?= $year2  ?: 2100 ?>" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Välj">
    </p>
    </fieldset>
</form>
<a href="<?= $movie ?>"><button>Visa alla</button></a>
