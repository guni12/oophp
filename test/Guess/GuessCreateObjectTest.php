<?php

namespace Guni\Guess;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class GuessCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $guess = new Guess();
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use only first argument.
     */
    public function testCreateObjectFirstArgument()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 6;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use both arguments.
     */
    public function testCreateObjectBothArguments()
    {
        $guess = new Guess(42, 7);
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $res = $guess->tries();
        $exp = 7;
        $this->assertEquals($exp, $res);

        $res = $guess->number();
        $exp = 42;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test makeGuess method with returned secret number.
     */
    public function testCreateAndPlayReturnedNumber()
    {
        $guess = new Guess();
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $num = $guess->number();
        $tries = $guess->tries() - 1;

        $res = $guess->makeGuess($num);
        $exp = "You got it! Well done! Correct number is " . $num . " and you have " . $tries . " remaining tries.<br />We reset the game.";
        $this->assertEquals($exp, $res);
        $guess->random();
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test makeGuess method with correct guess.
     */
    public function testCreateAndPlayParamNumber()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $tries = $guess->tries() - 1;

        $res = $guess->makeGuess(42);
        //$exp = "correct!!!"; //Mos
        $exp = "You got it! Well done! Correct number is 42 and you have " . $tries . " remaining tries.<br />We reset the game.";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test makeGuess method with too low guess.
     */
    public function testCreateAndPlayLowNumber()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $tries = $guess->tries() - 1;

        $res = $guess->makeGuess(24);
        //$exp = "to low...";
        $exp = "Your guess is too low. You have " . $tries . " remaining tries.";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test makeGuess method with too high guess.
     */
    public function testCreateAndPlayHighNumber()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $tries = $guess->tries() - 1;

        $res = $guess->makeGuess(82);
        //$exp = "to high...";
        $exp = "Your guess is too high. You have " . $tries . " remaining tries.";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test makeGuess method with too many guesses.
     */
    public function testCreateAndGuessAllWrong()
    {
        $guess = new Guess(42);
        $this->assertInstanceOf("\Guni\Guess\Guess", $guess);

        $test = 50;
        for ($i = 0; $i < 6; $i++) {
            $res = $guess->makeGuess($test);
            $test += 2;
        }

        //$exp = "no guesses left.";
        $exp = "Your guess is too high. You have 0 remaining tries.<br />No more guesses left. We reset the game.";
        $this->assertEquals($exp, $res);
    }
}
