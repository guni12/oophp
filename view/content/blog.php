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

$req = $this->di->get("request");
$base = $req->getBaseUrl() . "/";
$res = $res && is_array($res)? $res[0] : null;
$link = $res ? $base . $res->type : null;
$edit = $res ? $link . "/edit/" . $res->id : null;

$canEdit = $res->author == $thisUser ? "<a href='{$edit}'><button> Redigera </button></a>" : null;

if (!$res) {
    return;
}

?>
<br />
<?= $canEdit ?>

<article>
    <header>
    <h1><?= esc($res->title) ?></h1>
<?= $buttons ?>
        <p><i>Publicerad: <time datetime="<?= esc($res->published_iso8601) ?>" pubdate><?= esc($res->published) ?></time></i></p>
    </header>
    <?= $res->data ?>
</article>

<a href="<?= $link ?>"><button>Alla bloggtexter</button></a>
