<?php

require __DIR__ . '/vendor/autoload.php';

use CerfaReceiptsGen\Controller\App;
use CerfaReceiptsGen\Controller\Router;
use CerfaReceiptsGen\Controller\Request;
use CerfaReceiptsGen\Controller\Response;

// Basic route example
/* Router::get('/post/([0-9]*)', function (Request $request, Response $response) {
    $response->toJSON([
        'post' => ['id' => $request->params[0]],
        'status' => 'ok'
    ]);
}); */

App::run();