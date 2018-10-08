<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Formview.
 */
class FormviewContentTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Check IntroContent.
     */
    public function testCreateObjectIntroForm()
    {
        $form = new Formview();
        $this->assertInstanceOf("\Guni\Hundred\Formview", $form);

        $res = $form->getIntro();
        $exp = <<<EOD
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
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Check StartContent.
     */
    public function testCreateObjectStartForm()
    {
        $form = new Formview();
        $this->assertInstanceOf("\Guni\Hundred\Formview", $form);

        $res = $form->getStart();
        $exp = <<<EOD
<input type="submit" name="start" value="Högst kast börjar">
EOD;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Check PlayContent.
     */
    public function testCreateObjectPlayForm()
    {
        $form = new Formview();
        $this->assertInstanceOf("\Guni\Hundred\Formview", $form);

        $res = $form->getPlay();
        $exp = <<<EOD
    <input type="submit" name="doPlay" value="Kasta tärning">
    <br /><br />
    <input type="submit" name="keepRoll" value="Spara omgången">
    <br /><br />
    <input type="submit" name="reset" value="Återställ spelet">
EOD;
        $this->assertEquals($exp, $res);
    }
}
