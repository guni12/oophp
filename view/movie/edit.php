<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$buttons = $buttons ?? null;
$id = $movie->id ?? null;
$title = $movie->title ?? null;
$year = $movie->year ?? null;
$image = $movie->image ?? null;

$req = $this->di->get("request");
$base = $req->getBaseUrl();
$link = $base . "/movie";
$choose = $base . "/movie/movie-select"

?>
<h1><?= $title ?></h1>

<?= $buttons ?>

<form method="post">
    <fieldset>
    <legend>Redigera</legend>
    <input type="hidden" name="movieId" value="<?= $id ?>"/>

    <p>
        <label>Titel:<br> 
        <input type="text" name="movieTitle" value="<?= $title ?>"/>
        </label>
    </p>

    <p>
        <label>År:<br> 
        <input type="number" name="movieYear" value="<?= $year ?>"/>
    </p>

    <p>
        <label>Bild:<br> 
        <input type="text" name="movieImage" value="<?= $image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Spara">
        <input type="reset" value="Återställ">
    </p>
    <p>
        <a href="<?= $choose ?>"><button>Välj film</button></a>
    </p>
    </fieldset>
</form>

<a href="<?= $link ?>"><button>Visa alla</button></a>
