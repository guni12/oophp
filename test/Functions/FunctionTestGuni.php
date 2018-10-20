<?php

namespace Guni;

use PHPUnit\Framework\TestCase;

/**
 * Test function file.
 */
class FunctionTest extends TestCase
{

    /**
     * Test if post has this key
     */
    public function testHasKeyPost()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = array(
            'movieTitle' => "Bråkmakargatan"
        );
        $key = "movieTitle";
        $res = hasKeyPost($key);
        $this->assertTrue($res);
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



        /**
     * Test if text have substr to separate text
     */
    public function testHaveMore()
    {
        $str = "Första raden <!--more--> Andra raden";
        $res = haveMore($str);
        $this->assertTrue($res);

        $str = "En text helt utan separering";
        $res = haveMore($str);
        $this->assertFalse($res);
    }


    /**
     * Test function that devides a text and returns it with arrowcode
     */
    public function testPreMore()
    {
        $str = "Första raden <!--more--> Andra raden";
        $base = "path";
        $slug = "en-harlig-dag";
        $res = preMore($str, $base, $slug);
        $path = $base . "post/variadic/all/" . $slug;
        $exp = <<<EOD
Första raden <span class="orderby">
<a href="$path">&rarr;</a>
</span>
EOD;
        $this->assertEquals($exp, $res);
    }


    /**
     * Test function that devides a text and returns it with arrowcode
     */
    public function testWithoutMore()
    {
        $str = "Första raden utan more. Andra raden";
        $base = "path";
        $slug = "en-harlig-dag";
        $res = preMore($str, $base, $slug);
        $exp = <<<EOD
Första raden utan more. Andra raden
EOD;
        $this->assertEquals($exp, $res);
    }
}
