<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$action = $action ?? null;
$method = $method ?? null;
$title = $title ?? null;
$form = $form ?? null;

?>
<h1><?= $title ?></h1>
<form method="<?= $method ?>" action="<?= url($action) ?>">
    <?= $form ?>
</form>
