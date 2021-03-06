<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Hundred.
 */
class HundredCreateObjectTest extends TestCase
{
    /**
     * Setup mock for testing.
     */
    public function setUp()
    {
        $this->getMockBuilder('\Dice')
            ->setMethods(array('random'))
            ->getMock();
    }


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

        $exp = "Computer: <i class='dice-sprite dice-" . $first . "'></i> Anna: <i class='dice-sprite dice-" . $second . "'></i> <br /><br />Kasta tärning och spara undan när du är nöjd och innan du slår en etta. Annars är allt förlorat och turen går vidare. <br /><br/>Klicka också för att datorn ska spela sin omgång.";

        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Test playing and getting message for the game.
     */
    public function testCreateObjectPlay()
    {
        $computer = new Player("Dator", 20);
        $anna = new Player("Anna", 20);
        $list = [$computer, $anna];
        $players = new Hundred($list, 20);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $anna->setCurrentPlayer();
        $res = $players->playButton("Anna");
        $exp = "<i class='dice-sprite dice-";
        $this->assertStringStartsWith($exp, $res);


        $computer->setCurrentPlayer();
        $computer->setScore(101);
        $res = $players->playButton("Sebbe");
        $max = $computer->getHistogramMax();
        $exp = "Högsta värde: " . $max . "<br /><span class='red'>Dator vann!</span>";
        $this->assertContains($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Test Computer play.
     */
    public function testCreateObjectComputerRounds()
    {
        $computer = new Player("Dator", 5);
        $anna = new Player("Anna", 5);
        $list = [$computer, $anna];
        $players = new Hundred($list, 5);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $res = $players->ComputerRounds(0, 1, $computer);
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
        $exp = $players->getDetails()[1]->Graphtexts() . "<br />";
        $exp .= $players->histAsText();
        $max = $anna->getHistogramMax();
        if ($players->getDetails()[1]->getCheck()) {
            $exp .= '<span class="red">1: *</span><br />';
        }
        $exp .= "<br /><br />Högsta värde: " . $max . "<br />";
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
        $computer = new Player("Dator");
        $anna = new Player("Anna");
        $list = [$computer, $anna];
        $players = new Hundred($list);
        $this->assertInstanceOf("\Guni\Hundred\Hundred", $players);

        $computer->setScore(100);

        $res = $players->PlayAndCheckWinner(18, 1, $computer);
        $this->assertEquals("<span class='red'>Dator vann!</span><br />", $res);

        $res = $anna->isCurrentPlayer();
        $exp = true;
        $this->assertEquals($exp, $res);

        $res = $players->getCurrentPlayer();
        $exp = $anna;
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
        $exp = "Denna omgång: ". $temp . "<br />";

        $res = $players->getDetails()[0]->GetRoundMessage();
        $this->assertEquals($exp, $res);


        $name = $players->getDetails()[1]->getName();
        $lastroll = $players->getDetails()[1]->getLastRoll();
        $temp = $players->getDetails()[1]->getTemp();
        $score = $players->getDetails()[1]->getScore();
        $exp = "Denna omgång: ". $temp . "<br />";

        $res = $players->getDetails()[1]->GetRoundMessage();
        $this->assertEquals($exp, $res);
    }
}
