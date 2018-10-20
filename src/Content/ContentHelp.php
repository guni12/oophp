<?php
/**
 * Class ContentHelp
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Content;

use Guni\TextFilterGuni\TextFilter;

/**
 * A class to connect with database and handle sql-requests for pages and blogs.
 */
class ContentHelp
{
    /**
     * @var TextFilterGuni $filter Connection to the textfilter class
     */
    private $filter;


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
     * Constructor to initiate the object with $app, $paths and $filter.
     * @param \Anax\DI\DIMagic $app  the dependency/service container
     */

    public function __construct($app)
    {
        $this->app = $app;
        $this->databaseConfig = getSecrets();
        $this->paths = $this->getPaths();
        $this->slugs = $this->getSlugs();
        $this->filter = new TextFilter();
    }



    /**
     * Find out which current paths we have in table content
     *
     * @return array $temp containing all paths
     */
    public function getPaths()
    {
        
        $temp = [];
        $this->app->db->connect();
        $sql = "SELECT path FROM content;";
        $res = $this->app->db->executeFetchAll($sql);
        foreach ($res as $key => $value) {
            $temp[$key] = $value->path;
        }
        return $temp;
    }


    /**
     * Find out which current slugs we have in table content
     *
     * @return array $temp containing all slugs
     */
    public function getSlugs()
    {
        $temp = [];
        $this->app->db->connect();
        $sql = "SELECT slug FROM content;";
        $res = $this->app->db->executeFetchAll($sql);
        foreach ($res as $key => $value) {
            $temp[$key] = $value->slug;
        }
        return $temp;
    }




/**
     * Gets correct sql query depending of text-type
     *
     * @param string $type   the type of text we ask for.
     * @param int    $author id for the author used with blog
     *
     * @return string sql-query;
     */
    public function getSqlAllItems($type, $author = null)
    {
        $page = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;

        $post = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
JOIN oophpuser
ON content.author =
oophpuser.userid
WHERE 
    type= ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;

        $getAuthor = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601
FROM content
JOIN oophpuser
ON content.author =
oophpuser.userid
WHERE 
    author= ?
    AND (deleted IS NULL OR deleted > NOW())
ORDER BY published DESC
;
EOD;
        if ($author) {
            return $getAuthor;
        }
        return $type == "page" ? $page : $post;
    }




    /**
     * Gets correct sql query depending of text-type for one text
     *
     * @param string $value  The column value we are looking for
     * @param string $type   the type of text we ask for.
     * @param string $member part of path when used by a member
     *
     * @return string sql-query;
     */
    public function getSql($value, $type, $member = null)
    {
        $column = is_numeric($value) ? "id = ?" : "path = ?";
        $what = $type == "post" ? "slug = ?" : $column;
        $aswhat = $type == "post" ? "published" : "modified";
        $isUser = $this->app->session->get("user");

        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS {$aswhat}_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS {$aswhat}
FROM content
WHERE 
    {$what}
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;

        $sqlAdmin = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS {$aswhat}_iso8601
FROM content
WHERE 
    {$what}
    AND type = ?
ORDER BY published DESC
;
EOD;
        if ($member) {
            return $sqlAdmin;
        }
        return $isUser["userId"] == 2 ? $sqlAdmin : $sql;
    }



    /**
     * Make the textdata go through filter before view
     *
     * @param object $object containing textdata
     *
     * @return void
     */
    public function filterThem($object)
    {
        foreach ($object as $value) {
            $currentfilters = array_filter(array_map('trim', explode(",", $value->filter)), 'strlen');
            $value->data = $this->filter->parse($value->data, $currentfilters);
        }
    }



    public function checkContentSlug($slug, $type, $end, $title)
    {
        $temp = (!$slug) ? slugify($title) : $slug;

        if (in_array($slug, $this->slugs)) {
            $slug .= $end;
            $temp = $slug;
        }
        $temp = $type == "page" ? null : $slug;
        return $temp;
    }
}
