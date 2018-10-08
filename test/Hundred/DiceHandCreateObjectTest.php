<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectWithHistogram()
    {
        $hand = new DiceHand(7);
        $this->assertInstanceOf("\Guni\Hundred\DiceHand", $hand);

        $hand->roll();
        $hist = new Histogram();
        $hist->injectData($hand);
        $exp = array_sum($hist->getSerie());
        $res = $hand->sum();
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectAndGetHistogramMax()
    {
        $hand = new DiceHand(8);
        $this->assertInstanceOf("\Guni\Hundred\DiceHand", $hand);

        $hand->roll();
        $hist = new Histogram();
        $hist->injectData($hand);
        $exp = array_sum($hist->getSerie());
        $res = $hand->sum();
        $this->assertEquals($exp, $res);

        $res = $hand->getHistogramMax();
        $exp = $hist->getHistogramMax();
        $this->assertEquals($exp, $res);
    }
}
