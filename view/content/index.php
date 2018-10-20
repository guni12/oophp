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


//var_dump($res);

if (!$res) {
    return;
}

?>
<h1 class="green"><?= $title ?></h1>

<?= $buttons ?>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Titel</th>
        <th>Typ</th>
        <th>Publicerad</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><a href="<?= $base  . $row->type . "/variadic/" . ($row->slug ? esc($row->slug) : ( esc($row->path) ? esc($row->path) : $row->id)) ?>"><?= $row->title ?></a></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
    </tr>
<?php endforeach; ?>
</table>
