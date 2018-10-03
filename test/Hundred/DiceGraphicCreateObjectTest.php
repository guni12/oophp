<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGraphic.
 */
class DiceGraphicCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new DiceGraphic();
        $this->assertInstanceOf("\Guni\Hundred\DiceGraphic", $dice);

        $res = $dice->nrOfSides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Get last roll and compare to expected graphic string.
     */
    public function testCreateObjectWithGraphString()
    {
        $dice = new DiceGraphic();
        $this->assertInstanceOf("\Guni\Hundred\DiceGraphic", $dice);

        $dice->random();
        $roll = $dice->getLastRoll();
        $res = $dice->graphic();
        $exp = "dice-" . $roll;
        $this->assertEquals($exp, $res);
    }
}
