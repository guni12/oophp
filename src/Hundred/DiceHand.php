<?php
/**
 * Class DiceHand
 *
 * @package     Hundred
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Hundred;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand implements HistogramInterface
{
    use HistogramTrait;

    /**
     * @var Dice $dices   Array consisting of dices.
     */
    private $dices;

    /**
     * @var string  $graphs  Array consisting of last roll of the dices as strings.
     */
    private $graphs;

    /**
     * @var boolean $check  True if dicehand contains a one.
     */
    private $check = false;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $dices = 5)
    {
        $this->dices  = [];
        $this->graphs = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new DiceGraphic();
            $this->graphs[] = null;
        }
    }

    /**
     * Roll all dices save their value.
     *
     * @return void.
     */
    public function roll()
    {
        for ($i = 0; $i < count($this->dices); $i++) {
            $test = $this->dices[$i]->random();
            $this->graphs[] = $this->dices[$i]->graphic();
            $this->serie[] = $test;
            if ($test == 1) {
                $this->check = true;
            }
        }
    }


    /**
     * Get dices info.
     *
     * @return array with the dices objects.
     */
    public function getGraphs()
    {
        return $this->graphs;
    }


    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        $sum = array_sum($this->serie);
        return $sum;
    }


    /**
     * Inform if dice is one.
     *
     * @return true or false.
     */
    public function getCheck()
    {
        return $this->check;
    }
}
