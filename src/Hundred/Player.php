<?php

namespace Guni\Hundred;

/**
 * Showing off a standard class with methods and properties.
 */
class Player
{
    /**
     * @var int $score     The current player score.

     */
    private $lastRoll;
    private $name;
    private $score;
    private $temp;
    private $isCurrentPlayer;
    private $graph;
    private $dices;
    private $graphs;
    private $check;
    private $sum;


    /**
     * Constructor to initiate the object with current game settings,
     * if available.
     *
     * @param string $name  The name of the player
     */

    public function __construct(string $name, int $dices = 1)
    {
        $this->lastRoll = 0;
        $this->name = $name;
        $this->temp = 0;
        $this->score = 0;
        $this->isCurrentPlayer = false;
        $this->graphs = [];
        $this->dices = $dices;
        $this->check = false;
        $this->sum = 0;
    }


    /**
     * Randomize numbers for the dices rolls.
     *
     * @return int $sum rolled dices if not a one
     */
    public function rollHand()
    {
        $hand = new DiceHand($this->dices);
        //$res = $hand->roll();
        $this->graphs = $hand->getGraphs();
        $this->sum = $hand->sum();
        $this->temp += $sum;
        $this->gotOne($hand);
        return $sum;
    }



    /**
     * If player got a one, some settings change
     *
     * @return void
     */
    public function gotOne($hand)
    {
        $this->isCurrentPlayer = $hand->getCheck() ? false : true;
        $this->temp = $hand->getCheck() ? 0 : $this->temp;
    }



    /**
     * Randomize a number for the dice roll.
     *
     * @return int as the random number result
     */
    public function roll()
    {
        
        $dice = new DiceGraphic();
        $dice->random();
        $this->graph = $dice->graphic();
        $this->lastRoll = $dice->getLastRoll();
        $this->isCurrentPlayer = $dice->getLastRoll() == 1 ? false : true;
        $this->temp = $dice->getLastRoll() == 1 ? 0 : $this->temp + $dice->getLastRoll();
        return $dice->getLastRoll();
    }


    /**
     * Save last roll and add to players score
     * @return string message if a winner;
     */
    public function play()
    {
        $updated = $this->score + $this->temp;
        $this->setScore($updated);
        $this->temp = 0;
        $this->isCurrentPlayer = false;

        if ($this->getScore() >= 100) {
            return "<span class='red'>Congratulations - You won!</span>";
        }
    }



    /**
     * Set true or false if this player has it's turn
     *
     */
    public function setCurrentPlayer()
    {
        $this->isCurrentPlayer = true;
    }


    /**
     * Informs if it is this players turn to roll
     *
     * @return boolean true or false
     */
    public function isCurrentPlayer()
    {
        return $this->isCurrentPlayer;
    }



    /**
     * Reset the score
     *
     * @return void
     */
    public function resetScore()
    {
        $this->score = 0;
    }



    /**
     * Update current score
     *
     */
    public function setScore($number)
    {
        $this->score = $number;
    }



    /**
     * Get the current score.
     * @return int as the current score.
     */
    public function getScore()
    {
        return $this->score;
    }



    /**
     * Get the name of the player.
     * @return string as the player name.
     */
    public function getName()
    {
        return $this->name;
    }




    /**
     * Get the current temp.
     * @return int as the current temp points.
     */
    public function getTemp()
    {
        return $this->temp;
    }


    /**
     * Reset current temp.
     */
    public function resetTemp()
    {
        $this->temp = 0;
    }


    /**
     * Get the current roll.
     * @return int as the last rolled dice.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }


    /**
     * Get graphic illustration for dice
     * @return string as the last rolled dice with text
     */
    public function getGraphic()
    {
        return $this->graph;
    }



    /**
     * Get graphic illustrations for the current nr of dices
     * @return array as the last rolled dices with text
     */
    public function getGraphs()
    {
        return $this->graphs;
    }


    /**
     * Get info if dice side is one
     * @return true or false
     */
    public function getCheck()
    {
        return $this->check;
    }



    /**
     * Get message of current position.
     * @return string as information on score.
     */
    public function getMessage()
    {
        return "Current score for " . $this->getName() . " is: " . $this->getScore();
    }


        /**
     * Text info for the view
     *
     * @param obj    $current The player to describe
     * @param string $string  Info of which player
     *
     * @return string message for the view
     */
    public function getRoundMessage($string)
    {
        return $string . $this->getName() . "<br />This round: ". $this->getTemp() . "<br />Total: " . $this->getScore() . "<br />";
    }


    /**
     * Text that shows dices graphically for the view
     *
     * @return string @starter Info of dices rolls for the view
     */
    public function graphtexts()
    {
        $starter = null;
        foreach ($this->getGraphs() as $item) {
            if ($item) {
                $starter .= "<i class='dice-sprite " . $item . "'></i> ";
            }
        }
        return $starter;
    }


    /**
     * Text that shows one dice graphically for the view
     *
     * @return string @starter Info of one dice roll for the view
     */
    public function graphtext()
    {
        return "<i class='dice-sprite " . $this->getGraphic() . "'></i> ";
    }
}
