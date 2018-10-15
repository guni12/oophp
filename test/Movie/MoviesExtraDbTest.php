<?php

namespace Guni\Movie;

use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Buttons.
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class MoviesExtraDbTest extends TestCase
{
    protected $db;
    protected $di;


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
    public function testConstructMoviesExtraDb()
    {
        $_SERVER['SERVER_NAME'] = '';
        $mdb = new MoviesExtraDb();
        $this->assertInstanceOf("\Guni\Movie\MoviesExtradb", $mdb);
    }


    /**
     * Test new instance.
     */
    public function testMakeReset()
    {
        $_SERVER['SERVER_NAME'] = '';
        $mdb = new MoviesExtraDb();
        $exp = '<p>The command was: <code>';
        $res = $mdb->makeReset();
        $this->assertStringStartsWith($exp, $res);

        $exp = "Kopps";
        $this->assertContains($exp, $res);
    }



    /**
     * Test new instance.
     */
    public function testMakeResetbth()
    {
        $_SERVER['SERVER_NAME'] = 'www.student.bth.se';
        $mdb = new MoviesExtraDb();
        $exp = <<<EOD
        "id": "5",\n
EOD;
        $file = __DIR__ . "/../Mock/sqltext.sql";
        var_dump($file);
        $res = $mdb->makeResetbth($this->db, $file, 400);
        $this->assertContains($exp, $res);
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
