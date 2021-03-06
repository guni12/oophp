<?php
/**
 * Class Formview
 *
 * @package     Hundred
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Hundred;

/**
 * Class Formview that creates various forms for the view
 */
class Formview
{
    /**
     * Constructor for the formview
     */
    public function __construct()
    {
    }


    /**
     * Get the form to roll who starts the game
     * @return string for the veiw.
     */
    public function getStart()
    {
        $html = <<<EOD
<input type="submit" name="start" value="Högst kast börjar">
EOD;
        return $html;
    }


    /**
     * Get the form to play the game
     * @return string for the veiw.
     */
    public function getPlay()
    {
        $html = <<<EOD
    <input type="submit" name="doPlay" value="Kasta tärning">
    <br /><br />
    <input type="submit" name="keepRoll" value="Spara omgången">
    <br /><br />
    <input type="submit" name="reset" value="Återställ spelet">
EOD;
        return $html;
    }



    /**
     * Get the settings form to play the game
     * @return string for the veiw.
     */
    public function getIntro()
    {
        $html = <<<EOD
<p>Börja här:
    <input type="text" name="name" placeholder="Ditt användarnamn" value="" required="required">
    <input list="nrofdices" name="dices" placeholder="Antal tärningar" required="required">
    <datalist id="nrofdices">
        <option value="1">
        <option value="2">
        <option value="3">
        <option value="4">
        <option value="5">
    </datalist>
    <input type="submit" name="save" value="Spara">
    <br /><br />
</p>
EOD;
        return $html;
    }
}
