<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Hundred.
 */
class DiceHandCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectOneArgument()
    {
        $hand = new DiceHand(5);
        $this->assertInstanceOf("\Guni\Hundred\DiceHand", $hand);

        $hand->roll();
        $exp = array_sum($hand->values());
        $res = $hand->sum();
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectAndResetValues()
    {
        $hand = new DiceHand(8);
        $this->assertInstanceOf("\Guni\Hundred\DiceHand", $hand);

        $hand->roll();
        $exp = array_sum($hand->values());
        $res = $hand->sum();
        $this->assertEquals($exp, $res);

        $hand->resetValues();
        $res = $hand->values();
        $exp = array_fill(0, 8, null);
        $this->assertEquals($exp, $res);
    }
}
