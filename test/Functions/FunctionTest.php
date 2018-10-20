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
     * Test getting many posts values.
     */
    public function testGetPostArray()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = array(
            'movieTitle' => "Bråkmakargatan",
            'movieId' => 7,
            'movieProducer' => "Film i Väst",
            'staff' => ["Hanna", "Erik"]
        );
        $key = ["movieTitle", "movieId", "movieProducer", "staff"];
        $exp = ['movieTitle' => "Bråkmakargatan",'movieId' => 7,'movieProducer' => "Film i Väst", 'staff' => "Hanna,Erik,"];
        $res = getPost($key);
        $this->assertEquals($exp, $res);
    }



    /**
     * Test to slugify a text
     */
    public function testSlugify()
    {
        $str = "En härlig dag";
        $exp = "en-harlig-dag";
        $res = slugify($str);
        $this->assertEquals($exp, $res);
    }
}
