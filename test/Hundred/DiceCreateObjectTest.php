<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Guni\Hundred\Dice", $dice);

        $res = $dice->nrOfSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use an argument.
     */
    public function testCreateObjectWithArgument()
    {
        $dice = new Dice(8);
        $this->assertInstanceOf("\Guni\Hundred\Dice", $dice);

        $res = $dice->nrOfSides();
        $exp = 8;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test rolling the dice with random function and get saved side-number.
     */
    public function testCreateObjectUseRandomAndGetSide()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Guni\Hundred\Dice", $dice);

        $res = $dice->random();
        $exp = $dice->getLastRoll();
        $this->assertEquals($exp, $res);
    }
}
