<?php

namespace Guni\Hundred;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{
    /**
     * @var int $lastRoll The current dice side.
     * @var int $nrOfSides    Number of sides of the dice.
     */
    private $lastRoll;
    private $nrOfSides;



    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current result from dice roll.
     * @param int $nrOfSides  Number of sides, default 6.
     */

    public function __construct(int $sides = 6)
    {
        $this->nrOfSides = $sides;
    }


    /**
     * Randomize the dice roll between 1 and nr_of_sides.
     *
     * @return int as the random number when dice is rolled
     */
    public function random()
    {
        $this->lastRoll = mt_rand(1, $this->nrOfSides);
        return $this->lastRoll;
    }


    /**
     * Get the number of sides.
     * @return int as the amount of sides.
     */
    public function nrOfSides()
    {
        return $this->nrOfSides;
    }


    /**
     * Get the side number of last roll.
     * @return int as the side number.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
