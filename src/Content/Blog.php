<?php
/**
 * Class Blog
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
 * Blog class to handle requests about movies
 */
class Blog
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
     * Extracts all blogposts and sends to view
     *
     * @return void;
     */
    public function getAll($value = null)
    {
        $res = $this->cont->allItems("post", $value);
        if (!$res) {
            $this->app->page->add("anax/v2/article/default", [
                "class" => "green",
                "content" => '<h3>Du verkar inte ha skrivit några inlägg ännu</h3><p>Gå till medlemssidan och klicka på &quot;Gör ett inlägg&quot;.',
            ]);
        } else {
            $title = "Blogginlägg";
            if ($value) {
                $title = "Dina blogginlägg";
            }
            $this->app->page->add("content/blogs", [
                "res" => $res,
                "title" => $title,
            ]);
        }
    }



    /**
     * Extracts one blogpost and sends to view
     *
     * @param string $value the value we find our blog by
     *
     * @return void;
     */
    public function getOne($value)
    {
        $res = $this->cont->oneItem($value, "post");
        if (!$res) {
            $this->app->page->add("anax/v2/error/default", [
                "header" => "HTTP/1.0 404 Not Found",
                "title" => "404",
                "text" => "Sidan finns inte",
            ]);
        } else {
            $this->app->page->add("content/blog", [
                "res" => $res,
            ]);
        }
    }



    /**
     * Edit one blogpost
     *
     * @param string $value the value we find our blog by
     *
     * @return void;
     */
    public function editOne($value)
    {
        $loggedin = $this->app->session->get("user");
        $exist = $this->cont->editItem($value);
        if ($exist == array()) {
            $this->user->notExist();
        } elseif ($loggedin && ($loggedin["userId"] == 2 || $loggedin["userId"] == $exist->author)) {
            $where = $loggedin["userId"] == 2 ? "content/edit" : "content/editblog";
            $this->app->page->add($where, [
                "res" => $exist,
                "title" => $exist->title,
            ]);
        } else {
            $this->user->notAllowed();
        }
    }



    /**
     * Delete one blogpost
     *
     * @param string $value the value we find our blog by
     *
     * @return void;
     */
    public function deleteOne($value)
    {
        $res = $this->cont->deleteItem($value);
        $this->app->page->add("content/delete", [
            "res" => $res,
            "title" => $res->title,
        ]);
    }



    /**
     * Create new content
     *
     * @return void;
     */
    public function createContent()
    {
        $res = $this->cont->makeBlogContent();
        $this->app->page->add("content/createblog", [
            "title" => "Skriv lite",
            "res" => $res,
        ]);
    }
}
