<?php
/**
 * Class UserDb
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\User;

/**
 * Showing off a standard class with methods and properties.
 */
class UserDb
{
    /**
     * @var \Anax\DI\DIMagic $app the dependency/service container
     */
    protected $app;

    /**
     * @var array $databaseConfig settings for the database;
     */
    protected $databaseConfig;


    /**
     * Constructor to initiate the object with $app.
     * @param \Anax\DI\DIMagic $app  the dependency/service container
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->databaseConfig = getSecrets();
    }


    /**
     * Collects all users from database user
     *
     * @return object $res;
     */
    public function allUsers()
    {
        $this->app->db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE 
        WHEN (isdeleted <= NOW()) THEN "avslutad"
    END AS status
FROM oophpuser
;
EOD;
        $res = $this->app->db->executeFetchAll($sql);
        return $res;
    }



    /**
     * Collects one user by id from database user
     *
     * @param string $value The column value we are looking for
     *
     * @return object $res;
     */
    public function oneUser($value)
    {
        $this->app->db->connect();
        $sql = <<<EOD
SELECT * FROM oophpuser
WHERE userid = ?
;
EOD;

        $res = $this->app->db->executeFetchAll($sql, [$value]);
        return $res;
    }


    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        return $this->password = password_hash($password, PASSWORD_DEFAULT);
    }



    /**
     * Verify the user and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $user  user to check.
     * @param string $password the password to use.
     *
     * @return boolean true if user and password matches, else false.
     */
    public function verifyPassword($user, $password)
    {
        $check = $this->find("user", $user);
        if ($check) {
            return password_verify($password, password_hash($password, PASSWORD_DEFAULT));
        }
    }



    /**
     * Edit one user
     *
     * @param string $value The column id value we are looking for
     *
     * @return object $res;
     */
    public function editUser($value)
    {
        $this->app->db->connect();
        $req = $this->app->get("response");

        if (!$this->oneUser($value)) {
            return "This memberid does not exist";
        }

        if (hasKeyPost("doDelete") || hasKeyPost("doDeleteForever")) {
            $req->redirect("user/delete/" . $value);
        } elseif (hasKeyPost("doReset")) {
            $req->redirect("user/reset");
        } elseif (hasKeyPost("doCreate")) {
            $req->redirect("user/create");
        } elseif (hasKeyPost("doSave")) {
            $params = getPost([
                "userName",
                "userPassword",
                "userPassword1",
                "userPassword2",
                "contentAddBack",
                "userId"
            ]);


            $hashed = null;
            if (!$params["userPassword1"] == $params["userPassword2"]) {
                $hashed = $params["userPassword"];
            } else {
                $hashed = $this->setPassword($params["userPassword1"]);
            }

            $toinsert = [$params["userName"], $hashed, $params["userId"]];

            $sql = "UPDATE user SET user=?, password=? WHERE userid = ?;";

            if ($params["contentAddBack"] == "True") {
                $sql = "UPDATE user SET user=?, password=?, isdeleted=null WHERE userid = ?;";
            }

            $this->app->db->execute($sql, $toinsert);
        }

        $sql = "SELECT * FROM oophpuser WHERE userid = ?;";
        return $this->app->db->executeFetch($sql, [$value]);
    }



    /**
     * Check if user should be deleted and if so deletes it
     *
     * @param string  $userId the id to delete
     *
     * @return void;
     */
    public function deleteOne($userId)
    {
        $this->app->db->connect();
        $req = $this->app->get("response");

        if (hasKeyPost("doDelete")) {
            $contentId = getPost("userId");
            $sql = "UPDATE oophpuser SET isdeleted=NOW() WHERE userid=?;";
            $this->app->db->execute($sql, [$contentId]);
            $user = $this->app->session->get("user");
            $user["userId"] != 2 ? $this->app->session->delete("user") : null;
            $req->redirect("");
        } elseif (hasKeyPost("doDeleteForever")) {
            $sql = "DELETE FROM oophpuser WHERE userid = ?;";
            $this->app->db->execute($sql, [$userId]);
            $req->redirect("user");
        }

        $sql = "SELECT user, userid FROM oophpuser WHERE userid = ?;";
        return $this->app->db->executeFetch($sql, [$userId]);
    }



    /**
     * Get sqlfile and reset database content
     *
     * @return string $output;
     */
    public function makeReset()
    {
        $output = "";
        $file = realpath(__DIR__ . "/../..") . "/sql/user/setup.sql";
        $mysql  = isUnix() ? "/usr/bin/mysql" : "c:/xampp/mysql/bin/mysql.exe";
        $output = null;

        // Extract hostname and databasename from dsn
        $dsnDetail = [];
        preg_match("/mysql:host=(.+);port=([^;.]+);dbname=([^;.]+)/", $this->databaseConfig["dsn"], $dsnDetail);
        $host = $dsnDetail[1];
        $port = $dsnDetail[2];
        $database = $dsnDetail[3];
        $login = $this->databaseConfig["login"];
        $password = $this->databaseConfig["password"];

        $command = "$mysql --host={$host} --port={$port} -u{$login} -p{$password} $database < $file 2>&1";
        $showcommand = getCommand($mysql, $file);
        $output = [];
        $status = null;
        exec($command, $output, $status);
        $output = "<p>The command was: <code>$showcommand</code>.<br>The command exit status was $status."
            . "<br>The output from the command was:</p><pre>"
            . print_r($output, 1);


        return $output;
    }


    /**
     * Collects text from sqlfile and resets database content
     *
     * @param file $file A file containing sql-queries to reset a database
     * @param int $size The size of sql-querie for create table
     *
     * @return string $output;
     */
    public function makeResetbth($file, $size = 539)
    {
        $this->app->db->connect();

        $first = "DROP";
        $next = "CREATE TABLE";
        $ins = "INSERT";
        $sel = "SELECT";

        $contents = file_get_contents($file);
        $drop = substr($contents, strpos($contents, $first), 34);

        $create = substr($contents, strpos($contents, $next), $size);

        $insert = substr($contents, strpos($contents, $ins), 207);

        $select = substr($contents, strpos($contents, $sel), 66);

        $output = [];
        //var_dump($drop, $create, $insert, $select);


        $this->app->db->execute($drop);
        $this->app->db->execute($create);
        $this->app->db->execute($insert);
        $output = $this->app->db->executeFetchAll($select);
        $output = json_encode($output, JSON_PRETTY_PRINT);
        return "<pre>" . $output . "</pre>";
    }



    /**
     * Select user by username
     *
     * @param string $user the column we are seraching by
     *
     * @return object $obj the current user
     */
    public function getUserByUser($user)
    {
        $sql = <<<EOD
SELECT * FROM oophpuser
WHERE user = ?
;
EOD;
        return $this->app->db->executeFetchAll($sql, [$user]);
    }

    /**
     * Checks if user can login
     *
     * @return void;
     */
    public function doLogin()
    {
        $this->app->db->connect();
        $req = $this->app->get("response");

        if (hasKeyPost("doCreate")) {
            $req->redirect("user/create/");
        } elseif (hasKeyPost("doLogin")) {
            $params = getPost([
                "userName",
                "userPassword",
            ]);

            $check = $this->getUserByUser($params["userName"]);

            if ($check) {
                $id = $check[0]->userid;

                if ($check[0]->isdeleted != null) {
                    var_dump($check[0]);
                    return "<h3 class='green'>Inte längre medlem</h3>";
                }

                password_verify($params["userPassword"], password_hash($params["userPassword"], PASSWORD_DEFAULT));
                $params["userId"] = $id;
                $this->app->session->set("user", $params);
                $req->redirect("user/edit/" . $params["userId"]);
            } else {
                return "<h3 class='red'>Fel användarnamn eller lösenord</h3>";
            }
        }

        $isUser = $this->app->session->get("user");
        if ($isUser) {
            $req->redirect("user/edit/" . $isUser["userId"]);
        } else {
            return "<br /><h4>Här kan du bli medlem eller logga in om du redan är en av oss.</h4>";
        }
    }




    /**
     * Create a new user
     *
     * @return object $res;
     */
    public function makeUser()
    {
        $this->app->db->connect();
        $req = $this->app->get("response");

        if (hasKeyPost("doSave")) {
            $params = getPost([
                "userName",
                "userPassword",
                "userPassword2"
            ]);

            $hashed = null;
            if ($params["userPassword"] == $params["userPassword2"]) {
                $hashed = $this->setPassword($params["userPassword"]);

                $toinsert = [$params["userName"], $hashed];

                $sql = "INSERT INTO oophpuser (user, password) VALUES (?, ?);";
                $this->app->db->execute($sql, $toinsert);
                $req->redirect("user/login");
            } else {
                return "<h4 class='red'>Passwords must match</h4>";
            }
        }
    }
}
