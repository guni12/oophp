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
$max = $max ?? null;
$hits = $hits ?? 4;
$page = $page ?? 1;
$orderBy = $orderBy ?? "id";
$order = $order ?? "asc";

//var_dump($res);

if (!$res) {
    return;
}

$req = $this->di->get("request");
$base = $req->getBaseUrl() . "/";

$link = $base . "movie";
$start = $link . "/variadic/";
$end = "/" . $page . "/" . $orderBy . "/" . $order;
$two = $start . 2 . $end;
$four = $start . 4 . $end;
$eight = $start . 8 . $end;
$by = $base  . "movie/variadic/" . $hits . "/" . $page;
$byId = orderby3("id", $by);
$byTitle = orderby3("title", $by);
$byYear = orderby3("year", $by);
$byImage = orderby3("image", $by);

?>
<h1><?= $title ?></h1>

<?= $buttons ?>

<p>Filmer per sida: 
    <a href="<?= $two ?>"><button>2</button></a> | 
    <a href="<?= $four ?>"><button>4</button></a> | 
    <a href="<?= $eight ?>"><button>8</button></a>
</p>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id <?= $byId ?></th>
        <th>Bild <?= $byImage ?></th>
        <th>Titel <?= $byTitle ?></th>
        <th>År <?= $byYear ?></th>
    </tr>
    <?php $id = -1; foreach ($res as $row) :
        $id++; ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->id ?></td>
            <td><img class="thumb" src="<?= $base . $row->image ?>"></td>
            <td><?= $row->title ?></td>
            <td><?= $row->year ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p>
    Pages:
    <?php for ($i = 1; $i <= $max; $i++) : ?>
        <a href="<?= $base . "movie/variadic/{$hits}/" . $i . "/{$orderBy}/{$order}"?>"><button><?= $i ?></button></a> | 
    <?php endfor; ?>
</p>

<a href="<?= $link ?>"><button>Visa alla</button></a>
