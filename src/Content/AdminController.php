<?php
/**
 * Class AdminController
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

use Guni\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * This controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The AdminController is mounted on the route "admin" and can then handle all
 * requests for that mount point. This happens if isadmin is set in session.
 */
class AdminController implements ContainerInjectableInterface
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
        $admin = new \Guni\Content\Admin($this->di);
        $admin->getAll();
        $user = $this->di->session->get("user");
        if ($user && $user["userId"] == 2) {
            return $this->di->page->render();
        }
        return $this->di->page->render([], 403);
    }



    /**
     * This method handles:
     * admin/all
     *
     * @return object
     */
    public function allAction() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}");
        $admin = new \Guni\Content\Admin($this->di);
        $admin->getAllOf();
        $user = $this->di->session->get("user");
        if ($user && $user["userId"] == 2) {
            return $this->di->page->render();
        }
        return $this->di->page->render([], 403);
    }



    /**
     * This admin method action takes one argument:
     * GET admin/reset/<value>
     *
     * @param mixed $value
     *
     * @return object
     */
    public function resetAction() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $admin = new \Guni\Content\Admin($this->di);
        $admin->resetContent($this->di);
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
        $admin = new \Guni\Content\Admin($this->di);
        $admin->createContent($this->di);
        return $this->di->page->render();
    }




    /**
     * This user method resets datatables:
     *
     * @return object
     */
    public function resetuserAction() : object
    {
        //var_dump(__METHOD__ . ", \$db is {$this->db}, got argument '$value'");
        $admin = new \Guni\User\User($this->di);
        $admin->resetUser($this->di);
        $user = $this->di->session->get("user");
        if ($user && $user["userId"] == 2) {
            return $this->di->page->render();
        }
        return $this->di->page->render([], 403);
    }
}
