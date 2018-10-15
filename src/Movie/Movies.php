<?php
/**
 * Class Movies
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
class Movies
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
        $this->mdb = new MovieDb();
    }


    /**
     * Extracts all movies and sends to view
     *
     * @return void;
     */
    public function getAll()
    {
        $this->app->page->add("movie/index", [
            "res" => $this->mdb->allMovies($this->app->db),
            "title" => "Movies",
            "buttons" => $this->buttons,
        ]);
    }


    /**
     * Extracts movies by year sends to view
     *
     * @return void;
     */
    public function getYearSearch()
    {
        $this->app->page->add("movie/search-year", [
            "title" => "SELECT * WHERE year",
            "buttons" => $this->buttons,
        ]);

        $year1 = getGet("year1");
        $year2 = getGet("year2");

        $this->app->page->add("movie/index", [
            "res" => $this->mdb->yearSearch($this->app->db, $year1, $year2),
        ]);
    }



    /**
     * Extracts movies by title and sends to view
     *
     * @return void;
     */
    public function getTitleSearch()
    {
        $this->app->page->add("movie/search-title", [
            "title" => "SELECT * WHERE title",
            "buttons" => $this->buttons,
        ]);
        $searchTitle = getGet("searchTitle");
        $this->app->page->add("movie/index", [
            "res" => $this->mdb->titleSearch($this->app->db, $searchTitle),
        ]);
    }



    /**
     * Handles movie requests for editing and sends to the view
     *
     * @return void;
     */
    public function getCrud()
    {
        $begin = true;
        $title = "";
        $where = "";
        $movie = null;

        $movieId = getPost("movieId") ?: getGet("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear = getPost("movieYear");
        $movieImage = getPost("movieImage") ?? "img/noimage.png";

        $movies = $this->mdb->getAllByIdTitle($this->app->db);

        if (getPost("doEdit") && is_numeric($movieId)) {
            $begin = false;
            $this->doEdit($movieId);
        }
        if (getPost("doAdd")) {
            $begin = false;
            $title = "UPDATE movie";
            $where = "movie/edit";
        }
        if (getPost("doSave")) {
            $begin = false;
            $this->doSave($movieId, $movieTitle, $movieYear, $movieImage);
            $where = "movie/movie-select";
        }
        if (getPost("doDelete") && is_numeric($movieId)) {
            $begin = false;
            $this->doDelete($movieId);
        }
        if ($begin) {
            $where = "movie/movie-select";
            $title = "CRUD funktioner/ Välj en film";
        }

        $movies = $this->mdb->getAllByIdTitle($this->app->db);

        $this->app->page->add($where, [
            "title" => $title,
            "buttons" => $this->buttons,
            "movies" => $movies,
            "movie" => $movie,
        ]);
    }


    /**
     * Saves edited movies, extract all movies, and sends to the view
     *
     * @param string $movieId    The id of current movie
     * @param string $movieTitle The title of current movie
     * @param int    $movieYear  The productionyear of current movie
     * @param string $movieImage The url to image of current movie
     *
     * @return void;
     */
    public function doSave($movieId = null, $movieTitle = null, $movieYear = null, $movieImage = null)
    {
        if ($movieId != null) {
            $this->saveUpdate([$movieTitle, $movieYear, $movieImage, $movieId]);
        } else {
            $movieId = $this->saveInsert([$movieTitle, $movieYear, $movieImage]);
        }

        $res = $this->mdb->getAllbyTitle($this->app->db, $movieTitle);
        $this->app->page->add("movie/index", [
            "res" => $res,
        ]);
    }


    /**
     * Saves edited movie
     *
     * @param array $values The values to update
     *
     * @return void;
     */
    public function saveUpdate($values)
    {
        $this->mdb->updateMovie($this->app->db, $values);
        return "done";
    }


    /**
     * Insert new movie movie
     *
     * @param array $values The values to insert
     *
     * @return int $id;
     */
    public function saveInsert($values)
    {
        $id = $this->mdb->insertMovie($this->app->db, $values);
        return $id;
    }


    /**
     * Sends editing form to the view and handles updates by id
     *
     * @param string $movieId    The id of current movie
     *
     * @return void;
     */
    public function doEdit($movieId)
    {
        $movie = $this->mdb->updateById($this->app->db, $movieId);

        $this->app->page->add("movie/edit", [
            "title" => "UPDATE movie",
            "movie" => $movie[0],
            "buttons" => $this->buttons,
        ]);
    }


    /**
     * Deletes movie by id, collects all movies and sends to the view
     *
     * @param string $movieId    The id of current movie
     *
     * @return void;
     */
    public function doDelete($movieId)
    {
        $this->mdb->deleteById($this->app->db, $movieId);

        $this->app->page->add("movie/index", [
            "title" => "DELETE movie",
            "res" => $this->mdb->allMovies($this->app->db),
            "buttons" => $this->buttons,
        ]);
    }
}
