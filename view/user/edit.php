<?php

namespace Anax\View;

/**
 * Edit one user
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
$title = $title ?? null;
$res = $res ?? null;
$message = $message ?? null;

//var_dump($res);

$req = $this->di->get("request");
$base = $req->getBaseUrl() . "/";
$link = $base . "logout";
$reset = $base . "admin/resetuser";
$create = $base . "user/create";
$all = $base . "user";
$linktexts = $base . "post/all/" . esc($res->userid);
$createnew = $base . "post/create";
$alltexts = $base . "admin";

$session = $this->di->get("session");
$isloggedin = $session->get("user");

$logout = "<a href='{$link}'><button> Logga ut </button></a> | ";
$linkreset = "<a href='{$reset}'><button> Återställ databasen user </button></a> | ";
$linkcreate = "<a href='{$create}'><button> Lägg till medlem </button></a> | ";
$toAllLink = "<a href='{$all}'><button> Medlemmarna </button></a>";
$mytexts = "<a href='{$linktexts}'><button> Dina texter </button></a> | ";
$toalltexts = "<a href='{$alltexts}'><button> Alla texter </button></a> | ";
$newtext = "<a href='{$createnew}'><button> Gör ett blogginlägg </button></a> | ";

$password = esc($res->password);
$created = esc($res->iscreated);
$updated = esc($res->isupdated);
$deleted = esc($res->isdeleted);

$addBack = $res->isdeleted ? '<p><label>Lägg tillbaka denna medlem:<br><input type="checkbox" name="contentAddBack" value="True" /></p>' : null;

//var_dump($isloggedin);

$buttons = $isloggedin && ($isloggedin["userName"] == $res->user || $isloggedin["userId"] == 2) ? '<button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Uppdatera</button> | <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Återställ</button> | <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Sluta vara medlem</button>' : null;

$resetDatabase = $isloggedin && $isloggedin["userId"] == 2 ? $toalltexts . $linkreset . $linkcreate . $toAllLink : null;
$showPass = $isloggedin && $isloggedin["userId"] == 2 ? '<p><label>Lösenord:<br> <input type="text" name="userPassword" value="' . $password . '" readonly/></p>' : null;
$timeinfo = <<<EOD
<p>
    <label>Skapad:<br>
    <input type="datetime" name="userCreated" value="{$created}" readonly />
</p>
<p>
    <label>Uppdaterad:<br>
    <input type="datetime" name="userUpdated" value="{$updated}" readonly />
</p>
<p>
    <label>Kastad:<br>
    <input type="datetime" name="userDeleted" value="{$deleted}" readonly />
</p>
EOD;
$showStuff = $isloggedin && $isloggedin["userId"] == 2 ? $timeinfo : null;
$welcome = "<h3 class='green'>Välkommen till din sida " . $isloggedin["userName"] . "<br /><br />" . $logout . $mytexts . $newtext . $resetDatabase . "</h3><p>Här kan du ändra dina uppgifter och ta del av specialerbjudanden alltefter säsong.</p>";

$message = $isloggedin ? $welcome : null;

if (!$res) {
    return;
}

?>

<?= $message ?>

<form method="post">
    <fieldset>
    <legend>Ändra</legend>
    <p>
        <label>id:<br> 
        <input type="text" name="userId" value="<?= esc($res->userid) ?>" readonly />
        </label>
    </p>

    <p>
        <label>Användarnamn:<br> 
        <input type="text" name="userName" value="<?= esc($res->user) ?>"/>
        </label>
    </p>

    <?= $showPass ?>

    <p>
        <label>Nytt lösenord:<br> 
        <input type="text" name="userPassword1" value="" />
    </p>

    <p>
        <label>Nytt lösenord igen:<br> 
        <input type="text" name="userPassword2" value="" />
     </p>

    <?= $showStuff ?>

    <?= $addBack ?>

    <p>
        <?= $buttons?>
    </p>
    </fieldset>
</form>
