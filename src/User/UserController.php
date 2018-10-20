<?php
/**
 * Class UserController
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (04-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

use Anax\Route\Exception\ForbiddenException;
use Anax\Route\Exception\NotFoundException;
use Anax\Route\Exception\InternalErrorException;

/**
 * This controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The UserController is mounted on the route "user" and can then handle all
 * requests for that mount point.
 */
class UserController implements ContainerInjectableInterface
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
        $user = new \Guni\User\User($this->di);
        $user->getAll();
        return $this->di->page->render();
    }


    /**
     * This user method action takes one argument:
     * GET user/edit/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function editActionGet($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->editOne($value);
        return $this->di->page->render();
    }




    /**
     * This user method action takes one argument:
     * GET user/delete/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function deleteActionGet($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->deleteUser($value);
        return $this->di->page->render();
    }



    /**
     * This user method action creates new user:
     *
     * @return object
     */
    public function createAction() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->createUser($this->di);
        return $this->di->page->render();
    }



    /**
     * This user method action takes one argument:
     * GET user/login/<value>
     *
     * @return object
     */
    public function loginActionGet() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->login();
        return $this->di->page->render();
    }



    /**
     * This user method action takes one argument:
     * POST user/delete/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function deleteActionPost($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->deleteUser($value);
        return $this->di->page->render();
    }




    /**
     * This user method action takes one argument:
     * POST user/create/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function createActionPost() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->createUser($this->di);
        return $this->di->page->render();
    }



    /**
     * This user method action takes one argument:
     * POST user/login/<value>
     *
     * @return object
     */
    public function loginActionPost() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->login();
        return $this->di->page->render();
    }



    /**
     * This user method action takes one argument:
     * POST user/edit/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function editActionPost($value) : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $user = new \Guni\User\User($this->di);
        $user->editOne($value);
        return $this->di->page->render();
    }
}
