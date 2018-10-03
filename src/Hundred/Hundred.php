<?php

namespace Guni\Hundred;

/**
 * Class Hundred that keep score for various players
 */
class Hundred
{
    /**
     * @var int $dices The current nr of dices each round.

     */
    private $players;
    private $dices;


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
     * Sort the players according to highest startout roll
     *
     * @param obj $first  Player in this list of Players
     * @param obj $second Player in this list of Players
     *
     * @return the objects sorted by their lastRoll
     */
    public function sortObjectsByLastroll($first, $second)
    {
        return $first->getLastRoll() < $second->getLastRoll();
    }



    /**
     * Sort players by highest startout roll
     *
     * @return object
     */
    public function organizeOrder()
    {
        usort($this->players, array($this, "sortObjectsByLastroll"));
        return $this->players[0];
    }



    /**
     * Resets points for round and total
     *
     * @return void
     */
    public function reset()
    {
        foreach ($this->players as $player) {
            $player->resetScore();
            $player->resetTemp();
        }
    }



    /**
     * Startout roll for the game. Highest roll gets to start.
     *
     * @return string @starter Message of rolls and who gets to start
     */
    public function rollToStart()
    {
        $starter = "";
        foreach ($this->players as $player) {
            $player->roll();
            $starter .= $player->getName() . ": " . $player->graphtext();
        }
        $test = $this->organizeOrder();
        $starter .= "<br />" . $test->getName() . " gets to start";
        $this->getDetails()[0]->setCurrentPlayer();
        return $starter;
    }



    /**
     * Computer plays a number of times. If lastRoll is one turn goes to next player.
     *
     * @param int $pos1 A players place in this array
     * @param int $pos2 Second players place in array
     * @param boolean $check True if player got a one
     *
     * @return string $starter Message for the view
     */
    public function computerRounds($pos1, $pos2, $check)
    {
        $roundsum = 0;
        $starter = "";
        $rounds = $this->dices > 4 ? 2 : ($this->dices > 2 && $this->dices <= 4 ? 3 : 5);
        for ($i = 0; $i < $rounds; ++$i) {
            $roundsum = $this->getDetails()[$pos1]->rollHand();
            $starter .= $this->getDetails()[$pos1]->graphtexts() . "<br />";
            if ($check) {
                $this->getDetails()[$pos2]->setCurrentPlayer();
                break;
            }
        }
        $starter .= "<br />Computer makes " . $rounds . " rounds if it doesn't hit a one.<br />";
        $starter .= $this->playAndCheckWinner($roundsum, $pos2, $this->getDetails()[$pos1]);
        return $starter;
    }




    /**
     * Nameplayer plays it's turn. If lastRolls contains one turn goes to next player.
     *
     * @param int $pos1 A players place in this array
     * @param int $pos2 Second players place in array
     * @param boolean $check True if player got a one
     *
     * @return string $starter Message for the game
     */
    public function namePlayerRound($pos1, $pos2, $check)
    {
        $starter = "";
        $this->getDetails()[$pos1]->rollHand();
        if ($check) {
            $this->getDetails()[$pos2]->setCurrentPlayer();
        }
        $starter .= $this->getDetails()[$pos1]->graphtexts() . "<br />";
        return $starter;
    }



    /**
     * Save pints and check if currentplayer is winner.
     *
     * @param int $sum   Sum or lastrolls for the computer
     * @param int $second The other players place in playerArray
     * @param obj $who    The current player
     *
     * @return string $starter Message for the view
     */
    public function playAndCheckWinner($sum, $second, $who)
    {
        $starter = "";
        if ($sum > 1) {
            $who->play();
            if ($who->getScore() >= 100) {
                $starter = "<span class='red'>". $who->getName() . " won!</span><br />";
            }
        }
        $this->getDetails()[$second]->setCurrentPlayer();
        return $starter;
    }



    /**
     * Current player is either computer or human
     *
     * @param string $name    The human players name
     * @param obj    $current The current player
     * @param int    $pos1    Position in array of players
     * @param int    $pos2    Position in array of players
     *
     * @return string $starter Text info for the view
     */
    public function currentPlayer($name, $current, $pos1, $pos2)
    {
        $starter = "";
        if ($current->getName() == "Computer") {
            $starter.= $this->computerRounds($pos1, $pos2, $current->getCheck());
        } elseif ($current->getName() == $name) {
            $starter .= $this->namePlayerRound($pos1, $pos2, $current->getCheck());
        }
        return $starter;
    }


    /**
     * When button "Roll the dice" is pressed this happens
     *
     * @param string $name The human players name
     *
     * @return string $starter Info for the view
     */
    public function playButton($name)
    {
        $starter = "";
        $zero = 0;
        $one = 1;
        if ($this->getDetails()[0]->isCurrentPlayer() == true) {
            $starter .= $this->currentPlayer($name, $this->getDetails()[0], $zero, $one);
            $starter .= $this->getDetails()[0]->getRoundMessage("Firstplayer ");
        } elseif ($this->getDetails()[1]->isCurrentPlayer() == true) {
            $starter .= $this->currentPlayer($name, $this->getDetails()[1], $one, $zero);
            $starter .= $this->getDetails()[1]->getRoundMessage("Secondplayer ");
        }
        if ($this->getDetails()[0]->getScore() >= 100 || $this->getDetails()[1]->getScore() >= 100) {
            $this->reset();
        }

        return $starter;
    }
}
