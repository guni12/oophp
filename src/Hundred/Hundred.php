<?php
/**
 * Class Hundred
 *
 * @package     Hundred
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Hundred;

/**
 * Class Hundred that keep score for various players
 */
class Hundred
{
    /**
     * @var Player $players The players in the game
     */
    private $players;

    /**
     * @var int $dices   The current nr of dices each round.
     */
    private $dices;

    /**
     * @var array $histarray   Array of dices in current round.
     */
    private $histarray;

    /**
     * @var string $round            All dices in current round
     */
    private $round;


    /**
     * Constructor to initiate the object array with current players,
     * and nr of dices.
     *
     * @param array $players The player objects in the game
     * @param int   $dices   Chosen nr of dices for each round
     */

    public function __construct(array $players, int $dices = 1)
    {
        $this->players = $players;
        $this->dices = $dices;
        $this->histarray = [];
        $this->round = "";
    }



    /**
     * Get the list of the players.
     * @return array as all the players.
     */
    public function getDetails()
    {
        return $this->players;
    }



    /**
     * Startout roll for the game. Highest roll gets to start.
     *
     * @return string @message Message of rolls and who gets to start
     */
    public function rollToStart()
    {
        $message = "";
        foreach ($this->players as $player) {
            $player->roll();
            $message .= $player->getName() . ": " . $player->graphtext();
        }
        $this->misc = new Misc($this->players);
        $this->players = $this->misc->organizeOrder();
        $message .= "<br /><br />Kasta tärning och spara undan när du är nöjd och innan du slår en etta. Annars är allt förlorat och turen går vidare. <br /><br/>Klicka också för att datorn ska spela sin omgång.";
        $this->getDetails()[0]->setCurrentPlayer();
        return $message;
    }



    /**
     * Computer plays a number of times. If lastRoll is one turn goes to next player.
     *
     * @param int    $pos1  Zero or one for position in this->players array
     * @param int    $pos2  Zero or one for position in this->players array
     * @param Player $current The current player
     *
     * @return string $message Rolled dices as dicegraphs and histogram
     */
    public function computerRounds($pos1, $pos2, $current)
    {
        $roundsum = 0;
        $message = "";
        $histtemp = "";
        $histmax = 0;
        $rounds = $this->dices > 4 ? 2 : ($this->dices > 2 && $this->dices <= 4 ? 3 : 5);
        $i = 0;
        for ($i; $i < $rounds; ++$i) {
            $roundsum = $this->getDetails()[$pos1]->rollHand();
            $message .= $this->getDetails()[$pos1]->graphtexts() . "<br />";
            $this->histarray[] = $this->getDetails()[$pos1]->getHist();
            $histtemp = $this->histAsText();
            $histmax = $this->getDetails()[$pos1]->getHistogramMax() > $histmax ? $this->getDetails()[$pos1]->getHistogramMax() : $histmax;
            $average = $this->getDetails()[$pos1]->getAverage();
            if ($current->getCheck()) {
                $this->getDetails()[$pos2]->setCurrentPlayer();
                $this->histarray = [];
                break;
            }
            if ($average > 3.5 && $this->dices > 2) {
                $this->histarray = [];
                break;
            }
        }
        $message .= $histtemp;
        $message .= "<br /><br />Högsta värde: " . $histmax . "<br />";
        $message .= $this->playAndCheckWinner($roundsum, $pos2, $this->getDetails()[$pos1]);
        return $message;
    }



    /**
     * Nameplayer plays it's turn. If lastRolls contains one turn goes to next player.
     *
     * @param int    $pos1  Zero or one for position in this->players array
     * @param int    $pos2  Zero or one for position in this->players array
     * @param Player $check The current player
     *
     * @return string $message Rolled dices as dicegraphs and histogram
     */
    public function namePlayerRound($pos1, $pos2, $check)
    {
        $message = "";
        $this->getDetails()[$pos1]->rollHand();
        $this->histarray[] = $this->getDetails()[$pos1]->getHist();
        $this->round .= $this->getDetails()[$pos1]->graphtexts() . "<br />";
        $message .= $this->round;
        $message .= $this->histAsText();
        $message .= "<br /><br />Högsta värde: " . $this->getDetails()[$pos1]->getHistogramMax() . "<br />";
        if ($check->getCheck()) {
            $this->getDetails()[$pos2]->setCurrentPlayer();
            $this->histarray = [];
            $this->round = "";
        }
        return $message;
    }



    /**
     * Save pints and check if currentplayer is winner.
     *
     * @param int    $sum    Sum or lastrolls for the computer
     * @param int    $second The other players place in playerArray
     * @param Player $who    The current player
     *
     * @return string $message Winning message, if relevant, for the view
     */
    public function playAndCheckWinner($sum, $second, $who)
    {
        $message = "";
        if ($sum > 1) {
            $who->play();
            if ($who->getScore() >= 100) {
                $message = "<span class='red'>". $who->getName() . " vann!</span><br />";
            }
        }
        $this->getDetails()[$second]->setCurrentPlayer();
        return $message;
    }



    /**
     * Current player is either computer or human
     *
     * @param string $name    The human players name
     * @param Player $current The current player
     * @param int    $pos1    Position in array of players
     * @param int    $pos2    Position in array of players
     *
     * @return string $message Game feedback for the view
     */
    public function currentPlayer($name, $current, $pos1, $pos2)
    {
        $message = "";
        if ($current->getName() == "Dator") {
            $message.= $this->computerRounds($pos1, $pos2, $current);
        } elseif ($current->getName() == $name) {
            $message .= $this->namePlayerRound($pos1, $pos2, $current);
            $message .= $current->getRoundMessage();
        }
        return $message;
    }


    /**
     * Return a string with a textual representation of the histogram.
     *
     * @return string representing the histogram.
     */
    public function histAsText()
    {
        $res = "";
        $sorted = array_fill_keys(
            array('1', '2', '3', '4', '5', '6'),
            null
        );
        foreach ($this->histarray as $value) {
            foreach ($value as $key => $side) {
                $sorted[$side] .= '*';
            }
        }
        foreach ($sorted as $key => $value) {
            if ($value) {
                $span = $key == '1' ? '<span class="red">' : "";
                $end = $key == '1' ? '</span>' : "";
                $res .= $span . $key . ": " . $value . $end  . "<br />";
            }
        }
        return $res;
    }


    /**
     * When button "Roll the dice" is pressed the currentplayer gets to make a roll
     *
     * @param string $name The human players name
     *
     * @return string $message Game feedback for the view
     */
    public function playButton($name)
    {
        $message = "";
        $zero = 0;
        $one = 1;
        if ($this->getDetails()[0]->isCurrentPlayer() == true) {
            $message .= $this->currentPlayer($name, $this->getDetails()[0], $zero, $one);
        } elseif ($this->getDetails()[1]->isCurrentPlayer() == true) {
            $message .= $this->currentPlayer($name, $this->getDetails()[1], $one, $zero);
        }
        $message .= $this->getMessage();
        if ($this->getDetails()[0]->getScore() >= 100 || $this->getDetails()[1]->getScore() >= 100) {
            $this->getDetails()[0]->resetScore();
            $this->getDetails()[1]->resetScore();
        }
        return $message;
    }


    /**
     * Returns information of scores in the game
     *
     * @return string Info about the game for both players
     */
    public function getMessage()
    {
        return $this->getDetails()[0]->getMessage() . "<br/ >" . $this->getDetails()[1]->getMessage();
    }


    /**
     * Returns who is current player
     *
     * @return Player $current The current player
     */
    public function getCurrentPlayer()
    {
        $current = $this->getDetails()[0]->isCurrentPlayer() ? $this->getDetails()[0] : $this->getDetails()[1];
        return $current;
    }



    /**
     * Reset current round of rolls when turn moves to next player
     *
     * @return void
     */
    public function reset()
    {
        $this->histarray = [];
        $this->round = "";
    }
}
