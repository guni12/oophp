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
$link = $base . "admin/create";
$content = $base . "admin/reset";
$users = $base . "user";
$logout = $base . "logout";

//var_dump($res);

if (!$res) {
    return;
}

?>
<h1 class="green"><?= $title ?></h1>

<a href="<?= $link ?>"><button>Ny text</button></a> | 
<a href="<?= $content ?>"><button>Återställ databasen content</button></a> | 
<a href="<?= $users ?>"><button>Medlemmarna</button></a> |
<a href="<?= $logout ?>"><button> Logga ut </button></a>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Titel</th>
        <th>Typ</th>
        <th>Status</th>
        <th>Publicerad</th>
        <!--<th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>-->
        <th>Redigera</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><a href="<?= $base  . $row->type . "/variadic/" . ($row->slug ? esc($row->slug) : esc($row->path)) ?>"><?= $row->title ?></a></td>
        <td><?= $row->type ?></td>
        <td><?= $row->status ?></td>
        <td><?= $row->published ?></td>
        <!--<td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>-->
        <td><a class="icons" href="<?= $base  . $row->type . "/edit/" . $row->id ?>" title="Ändra">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            </a>
            <a class="icons" href="<?= $base  . $row->type . "/delete/" . $row->id ?>" title="Kasta">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
