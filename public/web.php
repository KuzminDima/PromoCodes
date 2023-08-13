<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/web.php';

use App\Kernel;
use App\Request\HttpRequest;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Session\Session;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = require_once __DIR__ . '/../services.php';

$kernel = new Kernel($container);
$request = HttpRequest::handle();

$session = new Session();
$session->start();

$container->bind(HttpRequest::class, $request);
$container->bind(Session::class, $session);

try {
    $kernel
        ->handle($request)
        ->send();
} catch (Exception $e) {
    throw $e;
    // TODO: add error handler
}
