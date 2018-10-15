<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$movies = $movies ?? null;
$buttons = $buttons ?? null;

$req = $this->di->get("request");
$base = $req->getBaseUrl();
$link = $base . "/movie";

?>
<h1><?= $title ?></h1>

<?= $buttons ?>

<form method="post">
    <fieldset>
    <legend>Välj film</legend>

    <p>
        <label>Film:<br>
        <select name="movieId">
            <option value="">Välj film...</option>
            <?php foreach ($movies as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" name="doAdd" value="Ny film">
        <input type="submit" name="doEdit" value="Redigera">
        <input type="submit" name="doDelete" value="Kasta">
    </p>
    </fieldset>
</form>
<a href="<?= $link ?>"><button>Visa alla</button></a>

