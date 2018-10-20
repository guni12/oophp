<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$buttons = $buttons ?? null;

$session = $this->di->get("session");
$user = $session->get("user");
$thisUser = $user["userId"];

//var_dump($res[0]->published, $res);

$req = $this->di->get("request");
$base = $req->getBaseUrl() . "/";
$link = $base . "post/create";
$linkedit = $base . "post/edit";

$canWrite = $thisUser ? '  | <a href="' . $link . '"><button>Ny text</button></a>' : null;

if (!$res) {
    return;
}

?>

<h1 class="green"><?= $title ?><?= $canWrite ?></h1>

<article>

    <?php foreach ($res as $row) : ?>
    <section>
        <header>
            <h1 class="green"><a href="<?= $base  . $row->type . "/variadic/" . (haveMore($row->data) ? "all/" : null) . ($row->slug ? esc($row->slug) : ( esc($row->path) ? esc($row->path) : $row->id)) ?>"><?= $row->title ?></a>
                <?= $thisUser == $row->author || $thisUser == 2 ? ' | <a href="' . $linkedit . "/" . $row->id . '"><button>Redigera</button></a>' : null ?>
            </h1>
            <p class="small"><i>Publicerad: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= $row->published ?></time></i></p>
        </header>
        <?= preMore($row->data, $base, $row->slug) ?>
        <p><i>Författare: <?= esc($row->user) ?></i></p>
    </section>
    <?php endforeach; ?>

</article>
