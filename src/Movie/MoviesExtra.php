<?php
/**
 * Class MoviesExtra
 *
 * @package     Movie
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Movie;

use Anax\DI\DIMagic;

/**
 * Movies class to handle requests about movies
 */
class MoviesExtra
{
    /**
     * @var DIMagic $app the dependency/service container
     */
    protected $app;


    /**
     * @var string $button The navigationlinks for our movie widgets
     */
    private $buttons;


    /**
     * @var MovieDb $mdb Connection to the database
     */
    private $mdb;


    /**
     * Constructor to initiate the object with $app.
     *
     * @param DIMagic $app    dependency/service container.
     */

    public function __construct(DIMagic $app = null)
    {
        $this->app = $app;
        $top = new Buttons();
        $this->buttons = $top->getButtons();
        $this->mdb = new MoviesExtraDb();
    }


    /**
     * Resets all movies from file sql/setup.sql
     *
     * @return void;
     */
    public function doReset()
    {
        $file = realpath(__DIR__ . "/../..") . "/sql/movie/setup_clean.sql";
        $test = getPost("reset") ? $this->mdb->makeReset() : "";
        $test2 = getPost("resetbth") ? $this->mdb->makeResetbth($this->app->db, $file) : "";
        $output = $test ? $test : $test2;
        $this->app->page->add("movie/reset", [
            "title" => "Återställ databasen",
            "output" => $output,
            "buttons" => $this->buttons,
        ]);
    }


    /**
     * Extracts all movies and sends to view
     *
     * @param array $params Nrof hits for each page, current page, order by column and order asc or desc
     *
     * @return void;
     */
    public function getAllPaginated($params = null)
    {
        $hits = $this->checkHits($params[0]);
        $max = $this->mdb->getMax($this->app->db, $hits);

        $page = $this->checkPage($max, $params[1]);
        $offset = $hits * ($page - 1);

        $orderBy = $this->checkColumn($params[2]);
        $order = $this->checkOrder($params[3]);

        $res = $this->mdb->getOrderedMovies($this->app->db, $orderBy, $order, $hits, $offset);
        //var_dump($hits, $max, $page, $offset, $columns, $orders, $orderBy, $order, $res);

        $this->app->page->add("movie/paginate", [
            "res" => $res,
            "title" => "Movies",
            "buttons" => $this->buttons,
            "max" => $max,
            "hits" => $hits,
            "page" => $page,
            "orderBy" => $orderBy,
            "order" => $order,
        ]);
    }



    /**
     * Check parameter string hits
     * @param string $param nr of hits
     *
     * @return int $hits;
     */
    public function checkHits($param = null)
    {
        return (int)$param ? (int)$param : 4;
    }


    /**
     * Check parameter string page
     *
     * @param int $max nr of possible pages
     * @param string $param page to show
     *
     * @return int $page;
     */
    public function checkPage($max, $param = null)
    {
        return (int)$param > 0 && (int)$param <= $max ? (int)$param : 1;
    }


    /**
     * Check parameter string column
     * @param string $param column name
     *
     * @return string $column;
     */
    public function checkColumn($param = null)
    {
        $columns = ["id", "title", "year", "image"];
        return (in_array($param, $columns)) ? $param : "id";
    }



    /**
     * Check parameter string order
     * @param string $param asc or desc order
     *
     * @return string $order;
     */
    public function checkOrder($param = null)
    {
        $orders = ["asc", "desc"];
        return in_array($param, $orders) ? $param : "asc";
    }
}
