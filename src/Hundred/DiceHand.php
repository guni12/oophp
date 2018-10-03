<?php

namespace Guni\Hundred;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
     * @var Dice $dices   Array consisting of dices.
     * @var int  $values  Array consisting of last roll of the dices.
     */
    private $dices;
    private $values;
    private $graphs;
    private $check = false;

    /**
     * Constructor to initiate the dicehand with a number of dices.
     *
     * @param int $dices Number of dices to create, defaults to five.
     */
    public function __construct(int $dices = 5)
    {
        $this->dices  = [];
        $this->values = [];
        $this->graphs = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new DiceGraphic();
            $this->values[] = null;
            $this->graphs[] = null;
        }
        //var_dump($this->dices, $this->values, $this->graphs);
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
            $this->values[] = $test;
            if ($test == 1) {
                $this->check = true;
            }
        }
        if ($this->check) {
            $this->resetValues();
        }
    }


    /**
     * Reset values if player rolls one.
     *
     * @return void.
     */
    public function resetValues()
    {
        $this->values = array_fill(0, count($this->dices), null);
    }



    /**
     * Get values of dices from last roll.
     *
     * @return array with values of the last roll.
     */
    public function values()
    {
        return $this->values;
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
     * Inform if dice is one.
     *
     * @return true or false.
     */
    public function getCheck()
    {
        return $this->check;
    }


    /**
     * Get the sum of all dices.
     *
     * @return int as the sum of all dices.
     */
    public function sum()
    {
        $sum = array_sum($this->values);
        return $sum;
    }
}
