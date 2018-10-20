<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$content = $content ?? null;
$buttons = $buttons ?? null;

if (!$content) {
    return;
}

?>
<h1 class="green"><?= $title ?></h1>

<?= $buttons ?>

<?= $content ?>

