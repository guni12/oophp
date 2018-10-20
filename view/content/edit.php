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
$link = $base . $res->type;
$filters = explode(",", $res->filter);
$addBack = $res->deleted ? '<p><label>Lägg tillbaka denna text:<br><input type="checkbox" name="contentAddBack" value="True" /></p>' : null;


if (!$res) {
    return;
}

?>
<form method="post">
    <fieldset>
    <legend>Ändra</legend>
    <p>
        <label>id:<br> 
        <input type="text" name="contentId" value="<?= esc($res->id) ?>" readonly />
        </label>
    </p>

    <p>
        <label>Titel:<br> 
        <input type="text" name="contentTitle" value="<?= esc($res->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Sökväg:<br> 
        <input type="text" name="contentPath" value="<?= esc($res->path) ?>" <?=$res->path == null ?  '' : 'readonly' ?>/>
    </p>

    <p>
        <label>Slug:<br> 
        <input type="text" name="contentSlug" value="<?= esc($res->slug) ?>" <?=$res->type == 'page' ?  'readonly' : '';?>/>
    </p>


    <p>
        <label>Text:<br> 
        <textarea name="contentData"><?= esc($res->data) ?></textarea>
     </p>

    <p>
        <label>Typ:<br> 
        <select name="contentType">
            <option value="">Välj typ...</option>
            <option value="post"<?=$res->type == 'post' ? ' selected="selected"' : '';?>>blog</option>
            <option value="page"<?=$res->type == 'page' ? ' selected="selected"' : '';?>>sida</option>
        </select>
    </p>

    <p>
        <label>Filter: - (Håll ner ctrl eller command knapp för att välja fler)<br> 
        <select name="contentFilter[]" multiple>
            <option value="bbcode"<?= in_array("bbcode", $filters) ? ' selected="selected"' : '';?>>bbcode to html</option>
            <option value="link"<?= in_array("link", $filters) ? ' selected="selected"' : '';?>>Gör klickbara länkar</option>
            <option value="markdown"<?= in_array("markdown", $filters) ? ' selected="selected"' : '';?>>Markdown omvandlare</option>
            <option value="nl2br"<?= in_array("nl2br", $filters) ? ' selected="selected"' : '';?>>Ny rad ger br</option>
            <option value="strip"<?= in_array("strip", $filters) ? ' selected="selected"' : '';?>>Ta bort taggar</option>
            <option value="esc"<?= in_array("esc", $filters) ? ' selected="selected"' : '';?>>Visa med taggar</option>
        </select>
    </p>

     <p>
        <label>Publicerad:<br> 
        <input type="datetime" name="contentPublish" value="<?= esc($res->published) ?>" />
    </p>

    <p>
        <label>Skapad:<br> 
        <input type="datetime" name="contentCreated" value="<?= esc($res->created) ?>" readonly />
    </p>

    <p>
        <label>Uppdaterad:<br> 
        <input type="datetime" name="contentUpdated" value="<?= esc($res->updated) ?>" readonly />
    </p>

    <p>
        <label>Kastad:<br> 
        <input type="datetime" name="contentDeleted" value="<?= esc($res->deleted) ?>" readonly />
    </p>

    <?= $addBack ?>

    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Spara</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Kasta</button>
        <button type="submit" name="doReset"><i class="fa fa-trash-o" aria-hidden="true"></i> Återställ databasen</button>
    </p>
    </fieldset>
</form>

<a href="<?= $link ?>"><button>Till alla</button></a>
