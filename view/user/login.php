<?php

namespace Anax\View;

/**
 * Edit one user
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<?= $message ?>

<form method="post">
    <fieldset>
    <legend>Logga in</legend>

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
        <button type="submit" name="doLogin"><i class="fa fa-floppy-o" aria-hidden="true"></i> Logga in</button> | <button type="submit" name="doCreate"><i class="fa fa-handshake-o" aria-hidden="true"></i> Bli medlem</button>
    </p>
    </fieldset>
</form>
