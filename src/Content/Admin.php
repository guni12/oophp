<?php
/**
 * Class Admin
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Content;

use Anax\DI\DIMagic;
use Guni\User\User;

/**
 * Admin class to handle requests about movies
 */
class Admin
{
    /**
     * @var DIMagic $app the dependency/service container
     */
    protected $app;


    /**
     * @var Content $cont Connection to the database
     */
    private $cont;


    /**
     * @var User $user Connection to userfunctions
     */
    private $user;


    /**
     * Constructor to initiate the object with $app.
     *
     * @param DIMagic $app    dependency/service container.
     */

    public function __construct(DIMagic $app = null)
    {
        $this->app = $app;
        $this->cont = new Content($app);
        $this->user = new User($app);
    }


    /**
     * Extracts all movies and sends to view
     *
     * @return void;
     */
    public function getAll()
    {
        $admin = $this->app->session->get("user");
        if ($admin && ($admin["userId"] == 2)) {
            $this->app->page->add("content/admin", [
                "res" => $this->cont->allContent(),
                "title" => "Alla texter",
            ]);
        } else {
            $this->user->notAllowed();
        }
    }



    /**
     * Resets all movies from file sql/setup.sql
     *
     * @return void;
     */
    public function resetContent()
    {
        $admin = $this->app->session->get("user");
        if ($admin && ($admin["userId"] == 2)) {
            $file = realpath(__DIR__ . "/../..") . "/sql/content/setup.sql";
            $test = getPost("reset") ? $this->cont->makeReset() : "";
            $test2 = getPost("resetbth") ? $this->cont->makeResetbth($file) : "";
            $output = $test ? $test : $test2;
            $this->app->page->add("content/reset", [
                "title" => "Återställ databasen content",
                "output" => $output,
            ]);
        } else {
            $this->user->notAllowed();
        }
    }



    /**
     * Create new content
     *
     * @return void;
     */
    public function createContent()
    {
        $admin = $this->app->session->get("user");
        if ($admin && ($admin["userId"] == 2)) {
            $this->app->page->add("content/create", [
                "title" => "Skriv lite",
                "res" => $this->cont->makeContent(),
            ]);
        } else {
            $this->user->notAllowed();
        }
    }
}
