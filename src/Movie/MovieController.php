<?php
/**
 * Class MovieController
 *
 * @package     Movie
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Movie;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * This controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The MovieController is mounted on the route "movie" and can then handle all
 * requests for that mount point.
 */
class MovieController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convenient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");
        $mdb = new \Guni\Movie\Movies($this->di);
        $mdb->getAll();
        return $this->di->page->render() ?? null;
    }



    /**
     * This movie method action is the handler for route:
     * GET movie/paginate
     *
     * @return object
     */
    public function paginateActionGet() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");
        $mdb = new \Guni\Movie\MoviesExtra($this->di);
        $mdb->getAllPaginated();
        return $this->di->page->render();
    }


    /**
     * This movie method action is the handler for route:
     * GET movie/searchy
     *
     * @return object
     */
    public function searchyActionGet() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");

        $mdb = new \Guni\Movie\Movies($this->di);
        $mdb->getYearSearch();
        return $this->di->page->render();
    }


    /**
     * This movie method action is the handler for route:
     * GET mountpoint/searcht
     *
     * @return object
     */
    public function searchtActionGet() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");

        $mdb = new \Guni\Movie\Movies($this->di);
        $mdb->getTitleSearch();
        return $this->di->page->render();
    }



    /**
     * This movie method action takes a variadic list of arguments:
     * GET movie/variadic/
     * GET movie/variadic/<value>
     * GET movie/variadic/<value>/<value>
     * GET movie/variadic/<value>/<value>/<value>
     * etc.
     *
     * @param array $value as a variadic parameter.
     *
     * @return object
     */
    public function variadicActionGet(...$value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value));
        $mdb = new \Guni\Movie\MoviesExtra($this->di);
        $mdb->getAllPaginated($value);
        return $this->di->page->render();
    }


    /**
     * This movie method action is the handler for route:
     * GET movie/select
     *
     * @return object
     */
    public function selectActionGet() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");

        $mdb = new \Guni\Movie\Movies($this->di);
        $mdb->getCrud();
        return $this->di->page->render();
    }


    /**
     * This movie method action is the handler for route:
     * POST movie/select
     *
     * @return object
     */
    public function selectActionPost() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");

        $mdb = new \Guni\Movie\Movies($this->di);
        $mdb->getCrud();
        return $this->di->page->render();
    }


    /**
     * This movie method action is the handler for route:
     * GET movie/reset
     *
     * @return object
     */
    public function resetActionGet() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");

        $mdb = new \Guni\Movie\MoviesExtra($this->di);
        $mdb->doReset();
        return $this->di->page->render();
    }


    /**
     * This movie method action is the handler for route:
     * Post movie/reset
     *
     * @return object
     */
    public function resetActionPost() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");

        $mdb = new \Guni\Movie\MoviesExtra($this->di);
        $mdb->doReset();
        return $this->di->page->render();
    }
}
