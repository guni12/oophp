<?php
/**
 * Class Testing
 *
 * @package     Guni
 * @subpackage  Redovisa
 * @author      Gunvor Nilsson gunvor@behovsbo.se
 * @version     v.0.1 (14-10-2018)
 * @copyright   Copyright (c) 2018, Molndal
 */
namespace Guni\TextFilterGuni;

use Anax\DI\DIMagic;

/**
 * Testing class to show off various filter methods
 */
class Testing
{

    /**
     * @var DIMagic $app the dependency/service container
     */
    protected $app;


    /**
     * @var string $button The navigationlinks for our filter tests;
     */
    private $buttons;


    /**
     * @var TextFilter $filter The textfilter class
     */
    private $filter;


    /**
     * @var text $bbcode Raw text
     */
    private $bbcode;


    /**
     * @var text $clickable Raw text
     */
    private $clickable;


    /**
     * @var text $sample Raw text
     */
    private $sample;


    /**
     * @var text $guni Raw text
     */
    private $guni;



    /**
     * Constructor to initiate the object with $app.
     *
     * @param DIMagic $app    dependency/service container.
     */

    public function __construct(DIMagic $app = null)
    {
        $this->app = $app;
        $top = new FilterButtons();
        $this->buttons = $top->getButtons();
        $this->filter = new TextFilter();
        $this->bbcode = file_get_contents(realpath(__DIR__ . "/../..") . "/text/bbcode.txt");
        $this->clickable = file_get_contents(realpath(__DIR__ . "/../..") . "/text/clickable.txt");
        $this->sample = file_get_contents(realpath(__DIR__ . "/../..") . "/text/sample.md");
        $this->guni = file_get_contents(realpath(__DIR__ . "/../..") . "/text/guni.txt");
    }



    /**
     * Get to all filtertesting via this view
     *
     * @return void;
     */
    public function getAll()
    {
        $text = "<br /><br />Olika filter ger oss olika möjligheter - testa de olika knapparna.";
        $this->app->page->add("filter/index", [
            "content" => $text,
            "title" => "Klicka för att testa",
            "buttons" => $this->buttons,
        ]);
    }



    /**
     * Shows clickable as is
     *
     * @return void;
     */
    public function getClickableRaw()
    {
        $this->app->page->add("filter/index", [
            "content" => "<pre>" . wordwrap(htmlentities($this->clickable)) . "</pre>",
            "title" => "clickable.text as is",
            "buttons" => $this->buttons,
        ]);
    }


    /**
     * Shows clickable filtered
     *
     * @return void;
     */
    public function getClickable()
    {
        $this->app->page->add("filter/index", [
            "content" => $this->clickable,
            "content" => $this->filter->makeClickable($this->clickable),
            "title" => "clickable - now clickable",
            "buttons" => $this->buttons,
        ]);
    }



    /**
     * Shows sample as is
     *
     * @return void;
     */
    public function getSampleRaw()
    {
        $this->app->page->add("filter/index", [
            "content" => "<pre>" . $this->sample . "</pre>",
            "title" => "Sample.md as is",
            "buttons" => $this->buttons,
        ]);
    }



    /**
     * Shows sample filtered
     *
     * @return void;
     */
    public function getSample()
    {
        $this->app->page->add("filter/index", [
            "content" => $this->filter->markdown($this->sample),
            "title" => "Sample.md through markdown filter",
            "buttons" => $this->buttons,
        ]);
    }




    /**
     * Shows sample filtered and using htmlentities to show source code
     *
     * @return void;
     */
    public function getSampleHtml()
    {
        $markdowned = $this->filter->markdown($this->sample);
        $this->app->page->add("filter/index", [
            "content" => "<pre>" . htmlentities($markdowned) . "</pre>",
            "title" => "Markdown filter plus htmlentities()",
            "buttons" => $this->buttons,
        ]);
    }



    /**
     * Shows sample filtered via parse()
     *
     * @return void;
     */
    public function getSampleParsed()
    {
        $parsed = $this->filter->parse($this->sample, ["markdown", "esc"]);
        $this->app->page->add("filter/index", [
            "content" => "<pre>" . $parsed . "</pre>",
            "title" => "Parsed via markdown and escape",
            "buttons" => $this->buttons,
        ]);
    }



    /**
     * Shows bbcode as is
     *
     * @return void;
     */
    public function getBbcodeRaw()
    {
        $this->app->page->add("filter/index", [
            "content" => "<pre>" . wordwrap(htmlentities($this->bbcode)) . "</pre>",
            "title" => "bbcode.text as is",
            "buttons" => $this->buttons,
        ]);
    }





    /**
     * Shows bbcode filtered to html
     *
     * @return void;
     */
    public function getBbcode()
    {
        $this->app->page->add("filter/index", [
            "content" => $this->filter->bbcode2html($this->bbcode),
            "title" => "bbcode filter to html",
            "buttons" => $this->buttons,
        ]);
    }



    /**
     * Testing very simple textfile
     *
     * @return void;
     */
    public function getGuniRaw()
    {
        $pre = $this->filter->parse("<pre>", ["esc"]);
        $this->app->page->add("filter/index", [
            "content" => $this->guni,
            "title" => "Text utan filter eller " . $pre,
            "buttons" => $this->buttons,
        ]);
    }




    /**
     * Testing very simple textfile as is
     *
     * @return void;
     */
    public function getGuniPre()
    {
        $pre = $this->filter->parse("<pre>", ["esc"]);
        $escaped = $this->filter->parse($this->guni, ["esc"]);
        $this->app->page->add("filter/index", [
            "content" => "<pre>" . wordwrap($escaped) . "</pre>",
            "title" => "Text utan filter med " . $pre,
            "buttons" => $this->buttons,
        ]);
    }



    /**
     * Testing very simple textfile
     *
     * @return void;
     */
    public function getGuni()
    {
        $this->app->page->add("filter/index", [
            "content" => $this->filter->parse($this->guni, ["nl2br"]),
            "title" => "simple text through nl2br()",
            "buttons" => $this->buttons,
        ]);
    }


    /**
     * Testing very simple textfile
     *
     * @return void;
     */
    public function getGuniStrip()
    {
        $this->app->page->add("filter/index", [
            "content" => $this->filter->parse($this->guni, ["strip", "nl2br"]),
            "title" => "Parsed also through strip_tags()",
            "buttons" => $this->buttons,
        ]);
    }
}
