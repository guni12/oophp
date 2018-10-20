<?php
/**
 * file functionguni
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */


/**
 * General functions for the namespace Guni/. File secret.php include password parameters
 */

/**
 * Check if key is set in POST.
 *
 * @param mixed $key     to look for
 *
 * @return boolean true if key is set, otherwise false
 */
function hasKeyPost($key)
{
    return array_key_exists($key, $_POST);
}



/**
 * Find out which operative system
 *
 * @return $options configuration for the database
 */
function isUnix()
{
    return (DIRECTORY_SEPARATOR == '/') ? true : false;
}



/**
 * Function to create links for sorting and keeping the original querystring.
 *
 * @param string $column the name of the database column to sort by
 * @param string $route  prepend this to the anchor href
 *
 * @return string with links to order by column.
 */
function orderby3($column, $route)
{
    $asc = $route . "/" . $column . "/asc";
    $desc = $route . "/" . $column . "/desc";
    return <<<EOD
<span class="orderby">
<a href="$asc">&darr;</a>
<a href="$desc">&uarr;</a>
</span>
EOD;
}




/**
 * Checks if string contains symbol for more.
 *
 * @param string $str the string to check.
 *
 * @return bool.
 */
function haveMore($str)
{
    $devide = "<!--more-->";
    if (strpos($str, $devide) !== false) {
        return true;
    }
    return false;
}



/**
 * Create a substr of a string, to be used as intro to text.
 *
 * @param string $str  the string to format as substr.
 * @param string $base basepath to page
 * @param string $slug slug to add to path
 *
 * @return str the substr.
 */
function preMore($str, $base, $slug = null)
{
    $path = $base . "post/variadic/all/" . $slug;
    $devide = "<!--more-->";
    if (haveMore($str)) {
        $arr = explode($devide, $str);
        $arrow = <<<EOD
<span class="orderby">
<a href="$path">&rarr;</a>
</span>
EOD;
        return $arr[0] . $arrow;
    }
    return $str;
}
