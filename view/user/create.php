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

$message = $res;

?>

<?= $message ?>

<form method="post">
    <fieldset>
    <legend>Bli medlem</legend>

    <p>
        <label>Användarnamn:<br> 
        <input type="text" name="userName" value=""/>
        </label>
    </p>

    <p>
        <label>Lösenord:<br> 
        <input type="text" name="userPassword" value="" />
    </p>


    <p>
        <label>Lösenordet igen:<br> 
        <input type="text" name="userPassword2" value="" />
     </p>

     <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Spara</button>

    </fieldset>
</form>
