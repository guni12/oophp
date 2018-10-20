<?php
/**
 * Class Content
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Content;

use Guni\Content\ContentHelp;

/**
 * A class to connect with database and handle sql-requests for pages and blogs.
 */
class Content
{
    /**
     * @var array $databaseConfig settings for the database;
     */
    private $databaseConfig;


    /**
     * @var array $paths current paths for the sight;
     */
    private $paths;


    /**
     * @var array $slugs current slugs in the database;
     */
    private $slugs;


    /**
     * @var \Anax\DI\DIMagic $app the dependency/service container
     */
    protected $app;



    /**
     * @var ContentHelp $help Helpfunctions for this Class
     */
    protected $help;


    /**
     * Constructor to initiate the object with $app, $paths and $slugs.
     * @param \Anax\DI\DIMagic $app  the dependency/service container
     */

    public function __construct($app)
    {
        $this->app = $app;
        $this->help = new ContentHelp($app);
        $this->databaseConfig = getSecrets();
        $this->paths = $this->help->getPaths();
        $this->slugs = $this->help->getSlugs();
    }


    /**
     * Collects all content from database content and adds status
     *
     * @return object $res;
     */
    public function allContent()
    {
        $this->app->db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE 
        WHEN (deleted <= NOW()) THEN "kastad"
        WHEN (published <= NOW()) THEN "Pub"
        ELSE "ejPub"
    END AS status
FROM content
;
EOD;

        $res = $this->app->db->executeFetchAll($sql);
        $this->help->filterThem($res);
        return $res;
    }



    /**
     * Collects all items from database content of type=?
     *
     * @param string $type  The text type we are looking for
     * @param string $value The id of user to search blogs from
     *
     * @return object $res;
     */
    public function allItems($type, $value = null)
    {
        $this->app->db->connect();
        $sql = $this->help->getSqlAllItems($type, $value);
        $supply = $value ? $value : $type;

        $res = $this->app->db->executeFetchAll($sql, [$supply]);
        $this->help->filterThem($res);
        return $res;
    }



    /**
     * Collects one item by type, slug from database content
     *
     * @param string $value The column value we are looking for
     * @param string $type The text type we are looking for
     *
     * @return object $res;
     */
    public function oneItem($value, $type)
    {
        $this->app->db->connect();
        $sql = $this->help->getSql($value, $type);
        if (is_array($value) && $value[0] == "all") {
            $sql = $this->help->getSql($value[1], $type, $value[0]);
            $value = $value[1];
        }
        $res = $this->app->db->executeFetchAll($sql, [$value, $type]);
        $this->help->filterThem($res);
        return $res;
    }






    /**
     * Edit one blogpost
     *
     * @param string $value The column value we are looking for
     *
     * @return object $res;
     */
    public function editItem($value)
    {
        $this->app->db->connect();
        $req = $this->app->get("response");

        if (hasKeyPost("doDelete")) {
            $req->redirect("post/delete/" . $value);
        } elseif (hasKeyPost("doReset")) {
            $req->redirect("admin/reset");
        } elseif (hasKeyPost("doSave")) {
            $params = getPost([
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentAddBack",
                "contentId"
            ]);

            //var_dump($params);

            if (!$params["contentSlug"]) {
                $params["contentSlug"] = slugify($params["contentTitle"]);
            }

            if ($params["contentType"]  == "page") {
                $params["contentSlug"] = null;
            }

            if (!$params["contentPublish"]) {
                $now = date("Y-m-d H:i:s");
                $params["contentPublish"] = $now;
            }

            if ($params["contentType"]  == "page") {
                $params["contentSlug"] = null;
            }

            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";

            if ($params["contentAddBack"] == "True") {
                $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=?, deleted=null WHERE id = ?;";
            }
            unset($params["contentAddBack"]);
            $this->app->db->execute($sql, array_values($params));
        }

        $sql = "SELECT * FROM content WHERE id = ?;";
        return $this->app->db->executeFetch($sql, [$value]);
    }



    /**
     * Delete one blogpost
     *
     * @param string $value The column value we are looking for
     *
     * @return object $res;
     */
    public function deleteItem($value)
    {
        $contentId = $value;
        $this->app->db->connect();

        if (hasKeyPost("doDelete")) {
            $contentId = getPost("contentId");
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $this->app->db->execute($sql, [$contentId]);
        } elseif (hasKeyPost("doDeleteForever")) {
            $sql = "DELETE FROM content WHERE id=?;";
            $this->app->db->execute($sql, [$contentId]);
            $req = $this->app->get("response");
            $req->redirect("admin");
        }

        $sql = "SELECT id, title, type FROM content WHERE id = ?;";
        return $this->app->db->executeFetch($sql, [$contentId]);
    }


    /**
     * Get sqlfile and reset database content
     *
     * @return string $output;
     */
    public function makeReset()
    {
        $output = "";
        $file = realpath(__DIR__ . "/../..") . "/sql/content/setup.sql";
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
    public function makeResetbth($file, $size = 728)
    {
        $this->app->db->connect();

        $first = "DROP";
        $next = "CREATE TABLE";
        $ins = "INSERT";
        $sel = "SELECT";

        $contents = file_get_contents($file);
        $drop = substr($contents, strpos($contents, $first), 31);

        $create = substr($contents, strpos($contents, $next), $size);

        $insert = substr($contents, strpos($contents, $ins), 1855);

        $select = substr($contents, strpos($contents, $sel), 81);

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
     * Create new texts
     *
     * @return object $res;
     */
    public function makeContent()
    {
        $this->app->db->connect();

        if (hasKeyPost("doSave")) {
            $params = getPost([
                "contentTitle",
                "contentPath",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish"
            ]);

            $end = date("-Y-m-d-H-i-s");

            $params["contentType"] = $params["contentType"] == null ? "page" : $params["contentType"];

            $params["contentPath"] = (($params["contentType"]  == "page") && ($params["contentPath"] == null)) ? $end : $params["contentPath"];

            $params["contentPath"] = $params["contentPath"]  == "" ? null : $params["contentPath"];

            if (in_array($params["contentPath"], $this->paths)) {
                $params["contentPath"] .= $end;
            }

            if (!$params["contentPublish"]) {
                $now = date("Y-m-d H:i:s");
                $params["contentPublish"] = $now;
            }

            $params["contentSlug"] = $this->help->checkContentSlug($params["contentSlug"], $params["contentType"], $end, $params["contentTitle"]);

            $params["contentAuthor"] = $params["contentType"]  == "page" ? 2 : $params["contentAuthor"];

            $sql = "INSERT INTO content (title, path, slug, data, type, filter, published, author) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
            $this->app->db->execute($sql, array_values($params));
            return $this->app->db->lastInsertId();
        }
    }



    /**
     * Create new blog content
     *
     * @return object $res;
     */
    public function makeBlogContent()
    {
        $this->app->db->connect();

        if (hasKeyPost("doSave")) {
            $params = getPost([
                "contentTitle",
                "contentSlug",
                "contentData",
                "contentType",
                "contentFilter",
                "contentPublish",
                "contentAuthor"
            ]);

            $end = date("-Y-m-d-H-i-s");

            if (!$params["contentSlug"]) {
                $params["contentSlug"] = slugify($params["contentTitle"]);
            }

            if (!$params["contentPublish"]) {
                $now = date("Y-m-d H:i:s");
                $params["contentPublish"] = $now;
            }

            if (in_array($params["contentSlug"], $this->slugs)) {
                $params["contentSlug"] = $params["contentSlug"] . $end;
            }

            $sql = "INSERT INTO content (title, slug, data, type, filter, published, author) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $this->app->db->execute($sql, array_values($params));
            return $this->app->db->lastInsertId();
        }
    }
}
