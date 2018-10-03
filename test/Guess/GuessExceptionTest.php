<?php

namespace Guni\Guess;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessExceptionTest extends TestCase
{
    
    /**
     * Construct object and verify that the object has the expected
     * properties. Test exception - out of bounds.
     *
     * @expectedExceptionMessage Missing configuration for layout
     */
    public function testCreateAndOutOfBounds()
    {
        $this->expectException(GuessException::class);

        $guess = new Guess(42);
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $res = $guess->makeGuess(120);
        $exp = "exp";
        $this->assertEquals($exp, $res);
    }
}
