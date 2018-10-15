<?php

namespace Guni\Movie;

use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Buttons.
 */
class MoviesTest extends TestCase
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

        $this->getMockBuilder('\MovieDb')
            ->setMethods(array('getAll', 'insertMovie', 'deleteMovie'))
            ->getMock();
    }



    /**
     * Inject $app into a class from Mock-directory.
     *
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    public function getApp()
    {
        $mock = new MockAppInjectable();
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $app = $di;
        $di->set("app", $app);
        $mock->setApp($app);
        $app = $mock->getApp();

        return $app;
    }


    /**
     * Inject $app into a class, the complicated way.
     */
    public function testInjectAppIntoMovies()
    {
        $app = $this->getApp();
        $mov = new Movies($app);
        $this->assertInstanceOf("\Guni\Movie\Movies", $mov);
    }


    /**
     * Inject mock $app into a class and use for reaching functions.
     */
    public function testInjectApp()
    {
        $mov = new Movies($this->app);
        $res = $mov->getAll();
        $this->assertNull($res);
    }


    /**
     * Inject mock $app into a class and test a function.
     */
    public function testgetYearSearch()
    {
        $mov = new Movies($this->app);
        $res = $mov->getYearSearch();
        $this->assertNull($res);
    }


    /**
     * Inject mock $app into a class and test a function.
     */
    public function testgetTitleSearch()
    {
        $mov = new Movies($this->app);
        $res = $mov->getTitleSearch();
        $this->assertNull($res);
    }


    /**
     * Inject mock $app into a class and test a function.
     */
    public function testgetCrud()
    {
        $mov = new Movies($this->app);
        $res = $mov->getCrud();
        $this->assertNull($res);
    }


    /**
     * Test saving new element and delete it.
     */
    public function testdoSaveWithArguments()
    {
        $mov = new Movies($this->app);

        $res = $mov->doSave("4", "Ny titel", 2018, "newimage.png");
        $this->assertNull($res);

        $res = $mov->doSave(null, "Annan titel", 2018, "secondimage.png");
        $this->assertNull($res);

        $res = $mov->doDelete("6");
        $this->assertNull($res);
    }



    /**
     * Inject mock $app into a class and test reaching functions.
     */
    public function testdoEditWithArguments()
    {
        $mov = new Movies($this->app);

        $res = $mov->doEdit("2");
        $this->assertNull($res);
    }


    /**
     * Inject mock $app and post before reaching functions.
     */
    public function testCrudWithPost()
    {
        $mov = new Movies($this->app);
        $_POST = array(
            'doAdd' => true
        );
        $res = $mov->getCrud();
        $this->assertNull($res);
        $_POST = array(
            'doAdd' => false,
            'doEdit' => true,
            'movieId' => 2
        );
        $res = $mov->getCrud();
        $this->assertNull($res);

        $_POST = array(
            'doEdit' => false,
            'doSave' => true
        );
        $res = $mov->getCrud();
        $this->assertNull($res);
        $_POST = array(
            'doSave' => false,
            'doDelete' => true,
            'movieId' => 4
        );
        $res = $mov->getCrud();
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
