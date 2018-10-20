<?php
/**
 * Class FilterButtons
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\TextFilterGuni;

/**
 * Showing off a standard class with methods and properties.
 */
class FilterButtons
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

        $bbcodeRaw = $base . "/filter/bbcode_raw";
        $bbcode = $base . "/filter/bbcode";
        $clickableRaw = $base . "/filter/clickable_raw";
        $clickable = $base . "/filter/clickable";
        $sampleRaw = $base . "/filter/sample_raw";
        $sample = $base . "/filter/sample";
        $sampleHtml = $base . "/filter/sample_html";
        $sampleParsed = $base . "/filter/sample_parsed";
        $guni = $base . "/filter/guni";
        $guniPre = $base . "/filter/guni_pre";
        $guniRaw = $base . "/filter/guni_raw";
        $guniStrip = $base . "/filter/guni_strip";
        $html = <<<EOD
<navbar class="navbar">
<a href="{$bbcodeRaw}"><button>bbcode_raw</button></a> | 
<a href="{$bbcode}"><button>bbcode</button></a> | 
<a href="{$clickableRaw}"><button>clickable_raw</button></a> | 
<a href="{$clickable}"><button>clickable</button></a> | 
<a href="{$sampleRaw}"><button>sample_raw</button></a> | 
<a href="{$sampleHtml}"><button>sample_html</button></a> | 
<a href="{$sample}"><button>sample</button></a> | 
<a href="{$sampleParsed}"><button>sample_parsed</button></a> | 
<a href="{$guniRaw}"><button>simple</button></a> | 
<a href="{$guniPre}"><button>with htmlent</button></a> | 
<a href="{$guni}"><button>nl2br</button></a> | 
<a href="{$guniStrip}"><button>strip_tags</button></a> | 
</navbar><br /><br />
EOD;
        return $html;
    }
}
