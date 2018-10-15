<?php

namespace Guni\Movie;

use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Buttons.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class MovieDbTest extends TestCase
{
    protected $db;
    protected $di;

    /*
    private $mysqlOptions = [
        // Set up details on how to connect to the database
        "dsn" => "mysql:host=127.0.0.1;dbname=test;",
        "username"        => "test",
        "password"        => "test",
        "driver_options"  => [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"],
        "fetch_mode"      => \PDO::FETCH_OBJ,
        "table_prefix"    => null,
        "session_key"     => "Anax\Database",
        "verbose" => true,
        "debug_connect"   => true
    ];*/



    private $sqliteOptions = [
        // Set up details on how to connect to the database
        "dsn" => "sqlite:memory::",
        "verbose" => false
    ];


    /**
     * Setup mock for testing.
     */
    public function setUp()
    {
        $this->db = new \Anax\Database\Database();
        $this->db->setOptions($this->sqliteOptions);
        //$this->db->setOptions($this->mysqlOptions);
        $this->db->connect();
        doCreateSqliteTable($this->db);
        //doCreateMysqlTable($this->db);
        doInserts($this->db);
    }


    /**
     * Test new instance.
     */
    public function testConstructMovieDb()
    {
        $mdb = new MovieDb();
        $this->assertInstanceOf("\Guni\Movie\Moviedb", $mdb);
    }


    /**
     * Test receiving object from database
     */
    public function testGetAllWithObjectFromDatabase()
    {
        $mdb = new MovieDb();
        $obj = new \stdClass();
        $obj->id = '1';
        $obj->title = 'Pulp fiction';
        $obj->year = 1994;
        $obj->image = 'img/pulp-fiction.jpg';
        $obj->director = null;
        $obj->length = null;
        $obj->plot = null;
        $obj->subtext = null;
        $obj->speech = null;
        $obj->quality = null;
        $obj->format = null;
        $exp = $obj;
        $res = $mdb->allMovies($this->db)[0];
        $this->assertEquals($exp, $res);
    }


    /**
     * Test function getAllByIdTitle
     */
    public function testGetAllByIdTitle()
    {
        $mdb = new MovieDb();
        $exp = "American Pie";
        $res = $mdb->getAllByIdTitle($this->db)[1]->title;
        $this->assertEquals($exp, $res);
    }


    /**
     * Test function yearSearch
     */
    public function testGetAllBetweenYears()
    {
        $mdb = new MovieDb();
        $exp = "Kopps";
        $res = $mdb->yearSearch($this->db, 1999, 2004)[2]->title;
        $this->assertEquals($exp, $res);

        $exp = "Pokémon The Movie 2000";
        $res = $mdb->yearSearch($this->db, null, 2004)[2]->title;
        $this->assertEquals($exp, $res);

        $exp = "Kopps";
        $res = $mdb->yearSearch($this->db, 1999, null)[2]->title;
        $this->assertEquals($exp, $res);
    }



    /**
     * Test function titleSearch
     */
    public function testGetAllByTitle()
    {
        $mdb = new MovieDb();
        $exp = 4;
        $res = $mdb->titleSearch($this->db, "Kopps")[0]->id;
        $this->assertEquals($exp, $res);

        $exp = null;
        $res = $mdb->titleSearch($this->db);
        $this->assertEquals($exp, $res);

        $exp = null;
        $res = $mdb->getAllByTitle($this->db);
        $this->assertEquals($exp, $res);
    }


    /**
     * Test update object
     */
    public function testUpdateAll()
    {
        $mdb = new MovieDb();
        $values = ['5', 'From Dusk To Dawn', 1998, 'img/from-dusk-till-dawn.jpg'];
        $mdb->updateMovie($this->db, $values);

        $arr = $mdb->getAllByTitle($this->db, 'From Dusk Till Dawn');
        $res = $arr[0]->title;
        $exp = 'From Dusk To Dawn';
        $this->assertNotEquals($exp, $res);
    }



    /**
     * Test insert object
     */
    public function testInsertMovie()
    {
        $mdb = new MovieDb();
        $values = ['Min nya film', 2018, 'img/beauty.jpg'];
        $newid = $mdb->insertMovie($this->db, $values);

        $arr = $mdb->getAllByTitle($this->db, 'Min nya film');
        $res = $arr[0]->id;
        $exp = $newid;
        $this->assertEquals($exp, $res);

        $arr = $mdb->updateById($this->db, "6");
        $exp = 'img/beauty.jpg';
        $res = $arr[0]->image;
        $this->assertEquals($exp, $res);

        $mdb->deleteById($this->db, 6);

        $res = $mdb->updateById($this->db, "6");
        $exp = array();
        $this->assertEquals($exp, $res);
    }


    /**
     * Find a movie by id
     */
    public function testGetMovie()
    {
        $mdb = new MovieDb();

        $arr = $mdb->updateById($this->db, "5");
        $exp = 1996;
        $res = $arr[0]->year;
        $this->assertEquals($exp, $res);
    }


    /**
     * Teardown mock after testing.
     */
    public function tearDown()
    {
        $this->db = null;
    }
}
