<?php
/**
 * Class Misc
 *
 * @package     Hundred
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Hundred;

/**
 * Class Misc for helpfunctions
 */
class Misc
{
    /**
     * @var array $serie  The numbers stored in sequence.
     */
    private $players = [];

    /**
     * Constructor to initiate the object array with current players.
     *
     * @param array $players The player objects in the game
     */

    public function __construct(array $players)
    {
        $this->players = $players;
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
        return $this->players;
    }
}
