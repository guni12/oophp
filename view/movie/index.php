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

if (!$res) {
    return;
}

$req = $this->di->get("request");
$base = $req->getBaseUrl();
$img = $base . "/cimage/img.php?src=";
$end = "&w=100";


?>
<h1><?= $title ?></h1>

<?= $buttons ?>


<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id </th>
        <th>Bild </th>
        <th>Titel </th>
        <th>År </th>
    </tr>
    <?php $id = -1; foreach ($res as $row) :
        $id++; ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->id ?></td>
            <?php $image = explode("/", $row->image) ?>
            <td><img class="figure" src="<?= $img . $image[1] . $end ?>"></td>
            <td><?= $row->title ?></td>
            <td><?= $row->year ?></td>
        </tr>
    <?php endforeach; ?>
</table>
