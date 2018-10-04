<?php
/**
 * Class Guess
 *
 * @package     Guess
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Guess;

use Guni\Guess\GuessException;

/**
 * Guess my number, with x number of tries. A class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int   $number  the current secret number
     */
    private $number;

    /**
     * @var int   $tries   number of tries a guess can be made before reset
     */
    private $tries;



    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in. Six is the default tries value.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */

    public function __construct(int $number = -1, int $tries = 6)
    {
        $this->number = $number == -1 ? mt_rand(1, 100) : $number;
        $this->tries = $tries;
    }




    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random()
    {
        $this->number = mt_rand(1, 100);
        $this->tries = 6;
    }



    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */

    public function tries()
    {
        return $this->tries;
    }




    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */

    public function number()
    {
        return $this->number;
    }




    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @param int $number the currently guessed number
     *
     * @return string $res to show the status of the guess made.
     */

    public function makeGuess($number)
    {
        if ($number <= 0 || $number >= 100 || is_nan($number)) {
            $this->tries -= 1;
            throw new GuessException("Number must be between 1 and 100.");
            return true;
        } else {
            $this->tries -= 1;
            $res = "";

            if ($number == $this->number) {
                $res = "You got it! Well done! Correct number is {$this->number} and you have {$this->tries} remaining tries.<br />We reset the game.";
                $this->random();
            } else if ($number < $this->number) {
                 $res = "Your guess is too low. You have {$this->tries} remaining tries.";
            } else if ($number > $this->number) {
                 $res = "Your guess is too high. You have {$this->tries} remaining tries.";
            }
            if ($this->tries <= 0) {
                $res .= "<br />No more guesses left. We reset the game.";
                $this->random();
            }
            return $res;
        }
    }
}
