<?php
/**
 * Class BlogController
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Content;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * This controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The BlogController is mounted on the route "blog" and can then handle all
 * requests for that mount point.
 */
class BlogController implements ContainerInjectableInterface
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
        $blog = new \Guni\Content\Blog($this->di);
        $blog->getAll();
        return $this->di->page->render() ?? null;
    }



    /**
     * This blog method action takes a variadic list of arguments:
     * GET post/variadic/
     * GET post/variadic/<value>
     * GET post/variadic/<value>/<value>
     * GET post/variadic/<value>/<value>/<value>
     * etc.
     *
     * @param array $value as a variadic parameter.
     *
     * @return object
     */
    public function variadicActionGet(...$value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got '" . count($value) . "' arguments: " . implode(", ", $value));
        $blog = new \Guni\Content\Blog($this->di);
        $blog->getOne($value);
        return $this->di->page->render();
    }


    /**
     * This blog method action takes one argument:
     * GET post/edit/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function editActionGet($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $blog = new \Guni\Content\Blog($this->di);
        $blog->editOne($value, $this->di);
        return $this->di->page->render();
    }


    /**
     * This blog method action takes one argument:
     * POST post/edit/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function editActionPost($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $blog = new \Guni\Content\Blog($this->di);
        $blog->editOne($value);
        return $this->di->page->render();
    }



    /**
     * This blog method action takes one argument:
     * GET post/edit/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function allActionGet($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $blog = new \Guni\Content\Blog($this->di);
        //$blog->allOf($value);
        $blog->getAll($value);
        return $this->di->page->render();
    }



    /**
     * This blog method action takes one argument:
     * GET post/delete/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function deleteActionGet($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $blog = new \Guni\Content\Blog($this->di);
        $blog->deleteOne($value);
        return $this->di->page->render();
    }


    /**
     * This blog method action takes one argument:
     * POST post/delete/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function deleteActionPost($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $blog = new \Guni\Content\Blog($this->di);
        $blog->deleteOne($value);
        return $this->di->page->render();
    }



    /**
     * This admin method action takes one argument:
     * GET admin/create/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function createAction() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $blog = new \Guni\Content\Blog($this->di);
        $blog->createContent($this->di);
        return $this->di->page->render();
    }
}
