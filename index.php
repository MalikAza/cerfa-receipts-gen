<?php

use Dotenv\Dotenv;
use CerfaReceiptsGen\Controller\App;
use CerfaReceiptsGen\Controller\Logger;
use CerfaReceiptsGen\Controller\Router;
use CerfaReceiptsGen\Controller\Request;
use CerfaReceiptsGen\Controller\Response;

require __DIR__ . '/vendor/autoload.php';
error_reporting(E_ALL ^ E_DEPRECATED);
Dotenv::createImmutable(__DIR__)->load();

// Basic route example
/* Router::get('/post/([0-9]*)', function (Request $request, Response $response) {
    $response->toJSON([
        'post' => ['id' => $request->params[0]],
        'status' => 'ok'
    ]);
}); */

App::run();