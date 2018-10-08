<?php
/**
 * Hundred game.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Play dice game Hundred
 */
$app->router->get("hundred", function () use ($app) {
    $data = [
        "title" => "Spela tärningsspelet hundra",
        "action" => "hundred/reset",
        "method" => "post",
    ];

    $formview = new Guni\Hundred\Formview();
    $form = $formview->getIntro();

    $data["form"] = $form;

    $app->session->delete("Hundra");
    $app->view->add("hundred/index", $data);
    return $app->page->render();
});




/**
 * Reset and start the game
 */
$app->router->post("hundred/reset", function () use ($app) {
    $dices = $app->request->getPost("dices");
    $name = $app->request->getPost("name");

    $game = new Guni\Hundred\Player($name, $dices);
    $computer = new Guni\Hundred\Player("Dator", $dices);
    $players = new Guni\Hundred\Hundred([$game, $computer], $dices);
    $app->session->set("Hundra", $players);
    $app->response->redirect("hundred/player");
});


/**
 * Player
 */
$app->router->any("GET|POST", "hundred/player", function () use ($app) {
    $data = [
        "action" => "hundred/player",
        "method" => "post",
    ];

    $players = $app->session->get("Hundra");
    $player = $players->getDetails()[0];
    $computer = $players->getDetails()[1];
    $message = "";
    $who = "Vem får börja?";
    $now = "Ställning";
    $formview = new Guni\Hundred\Formview();
    $form = $formview->getStart();

    if ($app->request->getPost("start")) {
        $message = $players->rollToStart();
        $who = $player->isCurrentPlayer() ? $player->getName() . " nästa" : "Dator nästa";
        $form = $formview->getPlay();
    } elseif ($app->request->getPost("doPlay")) {
        $now = $player->isCurrentPlayer() ? $player->getName() : "Dator";
        $message = $players->playButton($player->getName());
        $who = $player->isCurrentPlayer() ? $player->getName() . " nästa" : "Dator nästa";
        $form = $formview->getPlay();
    } elseif ($app->request->getPost("reset")) {
        $app->response->redirect("hundred");
    } elseif ($app->request->getPost("keepRoll")) {
        $message .= $player->play();
        $players->reset();
        $computer->setCurrentPlayer();
        $who = "Dator nästa";
        $now = $player->getName();
        $message .= $players->getMessage();
        $form = $formview->getPlay();
    }

    $data["form"] = $form;
    $data["message"] = $message;
    $data["title"] = $who;
    $data["score"] = $now;

    $app->view->add("hundred/player", $data);
    return $app->page->render();
});
