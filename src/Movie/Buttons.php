<?php
/**
 * Class Buttons
 *
 * @package     Movie
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\Movie;

/**
 * Showing off a standard class with methods and properties.
 */
class Buttons
{
    /**
     * Create some route buttons
     * @return string for the veiw.
     */
    public function getButtons()
    {
        $obj = new \Anax\Request\Request();
        $obj->init();
        $base = $obj->getBaseUrl();

        $searchyear = $base . "/movie/searchy";
        $searchtitle = $base . "/movie/searcht";
        $movieselect = $base . "/movie/select";
        $moviereset = $base . "/movie/reset";
        $moviepaginate = $base . "/movie/paginate";
        $html = <<<EOD
<navbar class="navbar">
<a href="{$searchyear}"><button>Sök År</button></a> | 
<a href="{$searchtitle}"><button>Sök Titel</button></a> | 
<a href="{$movieselect}"><button>Redigera</button></a> | 
<a href="{$moviereset}"><button>Reset</button></a> | 
<a href="{$moviepaginate}"><button>Paginera</button></a> | 
</navbar>
EOD;
        return $html;
    }
}
