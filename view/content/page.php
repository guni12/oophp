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
$res = $res[0];
$link = $base . $res->type;


if (!$res) {
    return;
}

?>
<article>
    <header>
    <h1 class="green"><?= esc($title) ?></h1>
<?= $buttons ?>
        <p class="small"><i>Senast uppdaterad: <time datetime="<?= esc($res->modified_iso8601) ?>" pubdate><?= esc($res->published) ?></time></i></p>
    </header>
    <?= $res->data ?>
</article>

<a href="<?= $link ?>"><button>Till alla</button></a>
