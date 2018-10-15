<?php

namespace Guni;

use PHPUnit\Framework\TestCase;

/**
 * Test function file.
 */
class FunctionTest extends TestCase
{
    /**
     * Test string with escape.
     */
    public function testEscape()
    {
        $str = '<script>alert("Hej!")</script>';
        $exp = "&lt;script&gt;alert(&quot;Hej!&quot;)&lt;/script&gt;";
        $res = esc($str);
        $this->assertEquals($exp, $res);
    }


    /**
     * Test string for ordering links.
     */
    public function testOrderby()
    {
        $route = "movie";
        $column = "title";
        $exp = <<<EOD
<span class="orderby">
<a href="{$route}orderby={$column}&order=asc">&darr;</a>
<a href="{$route}orderby={$column}&order=desc">&uarr;</a>
</span>
EOD;
        $res = orderby($column, $route);
        $this->assertEquals($exp, $res);
    }


    /**
     * Test string for ordering links with merge.
     */
    public function testOrderby2()
    {
        $asc = mergeQueryString(["orderby" => "title", "order" => "asc"], "movie");
        $desc = mergeQueryString(["orderby" => "title", "order" => "desc"], "movie");

        $exp = <<<EOD
<span class="orderby">
<a href="$asc">&darr;</a>
<a href="$desc">&uarr;</a>
</span>
EOD;
        $res = orderby2("title", "movie");
        $this->assertEquals($exp, $res);
    }


    /**
     * Test getting a get value.
     */
    public function testGetGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_GET = array(
            'movieId' => "Test"
        );
        $key = "movieId";
        $exp = "Test";
        $res = getGet($key);
        $this->assertEquals($exp, $res);
    }


    /**
     * Test getting a post value.
     */
    public function testGetPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = array(
            'movieTitle' => "Bråkmakargatan"
        );
        $key = "movieTitle";
        $exp = "Bråkmakargatan";
        $res = getPost($key);
        $this->assertEquals($exp, $res);
    }


    /**
     * Test getting a server value.
     */
    public function testQueryServer()
    {
        $_SERVER['REQUEST_METHOD'] = 'QUERY_STRING';
        $_SERVER['QUERY_STRING'] = "";
        $query = ["orderby" => "title", "order" => "asc"];
        $exp = parse_str($_SERVER['QUERY_STRING'], $query);
        $res = getServerParse($_SERVER['QUERY_STRING'], $query);
        $this->assertEquals($exp, $res);
    }



    /**
     * Test getting a server value.
     */
    public function testGetBthCommand()
    {
        $_SERVER["SERVER_NAME"] = "www.student.bth.se";
        $mysql = "mysql";
        $file = "file";
        $exp = "$mysql --host=blu-ray.student.bth.se -usecret -psecret guni12 < $file 2>&1";
        $res = getCommand($mysql, $file);
        $this->assertEquals($exp, $res);
    }


    /**
     * Test string for ordering links with merge.
     */
    public function testOrderby3()
    {
        $asc = "paginate/title/asc";
        $desc = "paginate/title/desc";
        $exp = <<<EOD
<span class="orderby">
<a href="$asc">&darr;</a>
<a href="$desc">&uarr;</a>
</span>
EOD;
        $res = orderby3("title", "paginate");
        $this->assertEquals($exp, $res);
    }
}
