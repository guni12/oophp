<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$res = $res ?? null;

$session = $this->di->get("session");
$user = $session->get("user");
$thisUser = $user["userId"];
$now = date("Y-m-d H:i:s");

$req = $this->di->get("request");
$base = $req->getBaseUrl() . "/";
//$link = $base . $res->type;

//var_dump($res);

?>
<form method="post">
    <fieldset>
    <legend>Skriv ny blogtext</legend>

    <input type="hidden" name="contentType" value="post"/>
    <input type="hidden" name="contentAuthor" value="<?= $thisUser ?>"/>

    <p>
        <label>Titel:<br> 
        <input type="text" name="contentTitle" value=""/>
        </label>
    </p>

    <p>
        <label>Slug: - den-mening-du-vill-ha-som-sokvag (kan byggas automatiskt)<br> 
        <input type="text" name="contentSlug" value=""/>
    </p>

    <p>
        <label>Text:<br> 
        <textarea name="contentData" value=""></textarea>
     </p>

    <p>
        <label>Filter: - (Håll ner ctrl eller command knapp för att välja fler)<br> 
        <select name="contentFilter[]" multiple>
            <option value="bbcode">bbcode to html</option>
            <option value="link">Gör klickbara länkar</option>
            <option value="markdown">Markdown omvandlare</option>
            <option value="nl2br">Ny rad ger br</option>
            <option value="strip">Ta bort taggar</option>
            <option value="esc">Visa med taggar</option>
        </select>
    </p>

     <p>
        <label>Ska publiceras:<br> 
        <input type="datetime" name="contentPublish" value="<?= $now ?>" />
    </p>

    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Spara</button>
    </p>
    </fieldset>
</form>
