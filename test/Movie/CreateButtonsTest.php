<?php

namespace Guni\Movie;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Buttons.
 */
class CreateButtonsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObject()
    {
        $nav = new Buttons();
        $this->assertInstanceOf("\Guni\Movie\Buttons", $nav);

        $obj = new \Anax\Request\Request();
        $obj->init();
        $base = $obj->getBaseUrl();

        $searchyear = $base . "/movie/searchy";
        $searchtitle = $base . "/movie/searcht";
        $movieselect = $base . "/movie/select";
        $moviereset = $base . "/movie/reset";
        $moviepaginate = $base . "/movie/paginate";
        $exp = <<<EOD
<navbar class="navbar">
<a href="{$searchyear}"><button>Sök År</button></a> | 
<a href="{$searchtitle}"><button>Sök Titel</button></a> | 
<a href="{$movieselect}"><button>Redigera</button></a> | 
<a href="{$moviereset}"><button>Reset</button></a> | 
<a href="{$moviepaginate}"><button>Paginera</button></a> | 
</navbar>
EOD;

        $res = $nav->getButtons();
        $this->assertEquals($exp, $res);
    }
}
