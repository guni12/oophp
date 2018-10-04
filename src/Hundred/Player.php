<?php
/**
 * Class Player
 *
 * @package     Hundred
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Hundred;

/**
 * Showing off a standard class with methods and properties.
 */
class Player
{
    /**
     * @var string $name            Name of the player
     */
    private $name;

    /**
     * @var int    $dices           Nr of dices to use each roll
     */
    private $dices;

    /**
     * @var int    $score           Current total points
     */
    private $score;

    /**
     * @var int    $lastRoll        The player's last roll.
     */
    private $lastRoll;

    /**
     * @var int    $temp            Current points for current round
     */
    private $temp;

    /**
     * @var bool   $isCurrentPlayer If it is the players turn to play
     */
    private $isCurrentPlayer;

    /**
     * @var string $graph           Lastroll as string
     */
    private $graph;

    /**
     * @var array  $graphs          Array of the dices rolled last as string representations
     */
    private $graphs;

    /**
     * @var bool   $check           True if player got a one as diceside
     */
    private $check;

    /**
     * @var int    $sum             Sum of all dices in last roll
     */
    private $sum;


    /**
     * Constructor to initiate the object with current game settings,
     * if available.
     *
     * @param string $name  The name of the player
     * @param int    $dices The number of dices to use each roll
     */

    public function __construct(string $name, int $dices = 1)
    {
        $this->name = $name;
        $this->dices = $dices;
        $this->temp = 0;
        $this->score = 0;
        $this->lastRoll = 0;
        $this->isCurrentPlayer = false;
        $this->graphs = [];
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
        $hand->roll();
        $this->graphs = $hand->getGraphs();
        $sum = $hand->sum();
        $this->temp += $sum;
        $this->gotOne($hand);
        return $sum;
    }



    /**
     * If player got a one, some settings change
     *
     * @param DiceHand $hand The current lastroll of dices
     *
     * @return void
     */
    public function gotOne($hand)
    {
        $this->isCurrentPlayer = $hand->getCheck() ? false : true;
        $this->temp = $hand->getCheck() ? 0 : $this->temp;
        $this->check = $hand->getCheck();
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
     *
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
     * @param int $number The total points
     */
    public function setScore($number)
    {
        $this->score = $number;
    }



    /**
     * Get the current score.
     *
     * @return int as the current score.
     */
    public function getScore()
    {
        return $this->score;
    }



    /**
     * Get the name of the player.
     *
     * @return string as the player name.
     */
    public function getName()
    {
        return $this->name;
    }




    /**
     * Get the current temp.
     *
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
     *
     * @return int as the last rolled dice.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }


    /**
     * Get graphic illustration for dice
     *
     * @return string as the last rolled dice with text
     */
    public function getGraphic()
    {
        return $this->graph;
    }



    /**
     * Get graphic illustrations for the current nr of dices
     *
     * @return array as the last rolled dices with text
     */
    public function getGraphs()
    {
        return $this->graphs;
    }


    /**
     * Get info if dice side is one
     *
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
     * @param string $string  Info if first or second player
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
