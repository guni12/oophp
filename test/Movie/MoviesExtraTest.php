<?php

namespace Guni\Movie;

use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Buttons.
 */
class MoviesExtraTest extends TestCase
{
    protected $app;
    protected $page;
    protected $db;


    /**
     * Setup mock for testing.
     */
    public function setUp()
    {
        $this->app = $this->getMockBuilder('\Anax\DI\DIMagic')
            ->getMock();

        $this->app->page = $this->getMockBuilder('\Anax\Page\Page')
            ->getMock();

        $this->app->db = $this->getMockBuilder('\Anax\Database\Database')
            ->getMock();

        $this->getMockBuilder('\MoviesExtraDb')
            ->setMethods(array('makeReset', 'makeResetbth', 'getMax', 'getOrderedMovies'))
            ->getMock();
    }


    /**
     * Inject mock $app into a class and use for reaching functions.
     */
    public function testInjectApp()
    {
        $mov = new MoviesExtra($this->app);
        $res = $mov->doReset();
        $this->assertNull($res);
    }


    /**
     * Inject mock $app into a class and use for reaching functions.
     */
    public function testGetAllPaginated()
    {
        $mov = new MoviesExtra($this->app);
        $res = $mov->getAllPaginated(["2", "2", "title", "desc"]);
        $this->assertNull($res);
    }


    /**
     * Teardown mock after testing.
     */
    public function tearDown()
    {
        // Restore the original superglobal to its pre-test state.
        $this->db = null;
        $this->page = null;
        $this->app = null;
    }
}
