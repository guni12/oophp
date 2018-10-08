<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$score = $score ?? null;
$message = $message ?? null;
$title = $title ?? null;
$method = $method ?? null;
$action = $action ?? null;
$form = $form ?? null;
?>

<div class="container">
    <div class="left">
        <h4><?= $score ?></h4>
        <p><?= $message ?></p>
    </div>
    <div class="right">
    <h1><?= $title ?></h1>

    <form method="<?= $method ?>" action="<?= url($action) ?>">
        <?= $form ?>
    </form>
    </div>

</div>