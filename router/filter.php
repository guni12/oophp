<?php
/**
 * Shows interesting movies.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Hub for all filters.
 */
$app->router->get("filter", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getAll();
    return $app->page->render();
});


/**
 * Shows bbcode text raw.
 */
$app->router->get("filter/bbcode_raw", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getBbcodeRaw();
    return $app->page->render();
});



/**
 * Shows bbcode filtered
 */
$app->router->get("filter/bbcode", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getBbcode();
    return $app->page->render();
});


/**
 * Shows clickable text raw
 */
$app->router->get("filter/clickable_raw", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getClickableRaw();
    return $app->page->render();
});



/**
 * Shows clickable text filtered
 */
$app->router->get("filter/clickable", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getClickable();
    return $app->page->render();
});


/**
 * Shows sample.md text raw
 */
$app->router->get("filter/sample_raw", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getSampleRaw();
    return $app->page->render();
});



/**
 * Shows sample.md text filtered
 */
$app->router->get("filter/sample", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getSample();
    return $app->page->render();
});


/**
 * Shows sample.md text filtered to html source
 */
$app->router->get("filter/sample_html", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getSampleHtml();
    return $app->page->render();
});


/**
 * Shows sample.md text filtered via parse()
 */
$app->router->get("filter/sample_parsed", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getSampleParsed();
    return $app->page->render();
});



/**
 * Testing very simple text file
 */
$app->router->get("filter/guni", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getGuni();
    return $app->page->render();
});



/**
 * Text file with nl2br
 */
$app->router->get("filter/guni_raw", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getGuniRaw();
    return $app->page->render();
});


/**
 * Text file with nl2br and strip_tags
 */
$app->router->get("filter/guni_strip", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getGuniStrip();
    return $app->page->render();
});


/**
 * Text file with pre as is
 */
$app->router->get("filter/guni_pre", function () use ($app) {
    $test = new \Guni\TextFilterGuni\Testing($app);
    $res = $test->getGuniPre();
    return $app->page->render();
});
