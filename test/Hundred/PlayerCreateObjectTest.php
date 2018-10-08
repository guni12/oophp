<?php

namespace Guni\Hundred;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectOneArgument()
    {
        $player = new Player("Anna");
        $this->assertInstanceOf("\Guni\Hundred\Player", $player);

        $res = $player->getName();
        $exp = "Anna";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Test letting Player roll the dice and get saved side-number.
     */
    public function testCreateObjectUseRandomAndGetLastRoll()
    {
        $player = new Player("Sebbe");
        $this->assertInstanceOf("\Guni\Hundred\Player", $player);

        $res = $player->roll();
        $exp = $player->getLastRoll();
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Test setting and getting if player is current player.
     */
    public function testCreateObjectTestIfCurrentPlayer()
    {
        $player = new Player("Sebbe");
        $this->assertInstanceOf("\Guni\Hundred\Player", $player);

        $player->setCurrentPlayer();
        $res = $player->isCurrentPlayer();
        $exp = true;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Reset and get score.
     */
    public function testCreateObjectTestResetAndGetScore()
    {
        $player = new Player("Sebbe");
        $this->assertInstanceOf("\Guni\Hundred\Player", $player);

        $player->resetScore();
        $res = $player->getScore();
        $exp = "0";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Reset and get temp.
     */
    public function testCreateObjectTestResetAndGetTemp()
    {
        $player = new Player("Sebbe");
        $this->assertInstanceOf("\Guni\Hundred\Player", $player);

        $player->resetTemp();
        $res = $player->getTemp();
        $exp = "0";
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Reset score and get message.
     */
    public function testCreateObjectResetScoreAndGetMessage()
    {
        $player = new Player("Sebbe");
        $this->assertInstanceOf("\Guni\Hundred\Player", $player);

        $player->resetScore();
        $res = $player->getMessage();
        $exp = "Sebbe: 0 poäng";
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Roll Play And GetGraphic.
     */
    public function testCreateObjectRollPlayAndGetGraphic()
    {
        $player = new Player("Sebbe");
        $this->assertInstanceOf("\Guni\Hundred\Player", $player);

        $player->setCurrentPlayer();
        $temp = $player->roll();
        $isStillCurrent = $temp > 1 ?? true ?? false;

        $res = $player->isCurrentPlayer();
        $exp = $isStillCurrent;
        $this->assertEquals($exp, $res);

        $player->play();
        $res = $player->isCurrentPlayer();
        $exp = false;
        $this->assertEquals($exp, $res);

        $res = $player->getTemp();
        $exp = "0";
        $this->assertEquals($exp, $res);

        $res = $player->getGraphic();
        $exp = "dice-" . $temp;
        $this->assertEquals($exp, $res);
    }
}
