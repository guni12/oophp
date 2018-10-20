<?php

namespace Anax\View;

/**
 * View to edit users.
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
$base = $req->getBaseUrl() . "/user/";
$link = $base . "reset";
$create = $base . "create";
$img = $base . "/cimage/img.php?src=";
$end = "&w=100";


?>
<div class = "movedown"></div>
<h1><?= $title ?></h1>

<a href="<?= $link ?>"><button>Återställ databasen user</button></a> | 
<a href="<?= $create ?>"><button> Lägg till medlem </button></a>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id </th>
        <th>Medlem </th>
        <th>Status </th>
        <th>Skapad </th>
        <th>Ändra </th>
    </tr>
    <?php $id = -1; foreach ($res as $row) :
        $id++; ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->userid ?></td>
            <td><a href="<?= $base  . "edit/" . $row->userid ?>"><?= $row->user ?></td>
            <td><?= $row->status ?></td>
            <td><?= $row->iscreated ?></td>
            <td><a class="icons" href="<?= $base  . "edit/" . $row->userid ?>" title="Ändra">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <a class="icons" href="<?= $base  . "delete/" . $row->userid ?>" title="Kasta">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
