<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Hundred.
 */
class HundredCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectOneArgument()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $res = $players->getDetails()[0]->getName();
        $exp = "Computer";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test reaching individual players.
     */
    public function testCreateObjectAndReachOnePlayer()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $first = $players->getDetails()[0];
        $players->reset();

        $res = $first->getScore();
        $exp = "0";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test rolling for player to start game.
     */
    public function testCreateObjectRollToStart()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $res = $players->rollToStart();
        $first = $computer->getLastRoll();
        $second = $anna->getLastRoll();

        $largest = $second > $first ? "Anna" : "Computer";

        $exp = "Computer: <i class='dice-sprite dice-" . $first . "'></i> Anna: <i class='dice-sprite dice-" . $second . "'></i> <br />" . $largest . " gets to start";

        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Test playing and getting message for the game.
     */
    public function testCreateObjectPlay()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna", 20);
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $anna->setCurrentPlayer();
        $res = $players->playButton("Anna");
        //$exp = "<br />Secondplayer Anna<br />This round: 0<br />Total: 0<br />";
        $exp = "<i class='dice-sprite dice-";
        $this->assertStringStartsWith($exp, $res);


        $computer->setCurrentPlayer();
        $computer->setScore(101);
        $res = $players->playButton("Computer");
        //$exp = "<br /><br /><br /><br /><br /><br />Computer makes 5 rounds if it doesn't hit a one.<br />Firstplayer Computer<br />This round: 0<br />Total: 101<br />";
        $exp = "<i class='dice-sprite dice-";
        $this->assertStringStartsWith($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Test Computer play.
     */
    public function testCreateObjectComputerRounds()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list, 5);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $res = $players->ComputerRounds(0, 1, $computer);
        //$exp = "<br /><br />Computer makes 2 rounds if it doesn't hit a one.<br />";
        $exp = "<i class='dice-sprite dice-";
        $this->assertStringStartsWith($exp, $res);

        $res = $anna->isCurrentPlayer();
        $exp = true;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test Anna.
     */
    public function testCreateObjectAnna()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $anna->rollHand();
        $res = $players->NamePlayerRound(1, 0, $anna);
        $test = $players->getDetails()[1]->Graphtexts();
        $exp = $test . "<br />";
        $this->assertEquals($exp, $res);


        $computer->setCurrentPlayer();
        $res = $computer->isCurrentPlayer();
        $exp = true;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test Computer play.
     */
    public function testCreateObjectComputerPlay()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $computer->setScore(100);

        $res = $players->PlayAndCheckWinner(18, 1, $computer);
        $this->assertEquals("<span class='red'>Computer won!</span><br />", $res);

        $res = $anna->isCurrentPlayer();
        $exp = true;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test First Message.
     */
    public function testCreateObjectAndGetMessage()
    {
        $computer = new Player("Computer");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $name = $players->getDetails()[0]->getName();
        $lastroll = $players->getDetails()[0]->getLastRoll();
        $temp = $players->getDetails()[0]->getTemp();
        $score = $players->getDetails()[0]->getScore();
        $exp = "Firstplayer " . $name . "<br />This round: ". $temp . "<br />Total: " . $score . "<br />";

        $res = $players->getDetails()[0]->GetRoundMessage("Firstplayer ");
        $this->assertEquals($exp, $res);


        $name = $players->getDetails()[1]->getName();
        $lastroll = $players->getDetails()[1]->getLastRoll();
        $temp = $players->getDetails()[1]->getTemp();
        $score = $players->getDetails()[1]->getScore();
        $exp = "Secondplayer " . $name . "<br />This round: ". $temp . "<br />Total: " . $score . "<br />";

        $res = $players->getDetails()[1]->GetRoundMessage("Secondplayer ");
        $this->assertEquals($exp, $res);
    }
}
