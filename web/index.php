<?php

/**
 * Main controller for project
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */

ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';
$app = include __DIR__ . '/../src/app.php';
require __DIR__ . '/../config/prod.php';
require __DIR__ . '/../src/controllers.php';
require __DIR__ . '/../src/ProductTypeController.php';
require __DIR__ . '/../src/OrderController.php';
require __DIR__ . '/../src/ZoneController.php';
require __DIR__ . '/../src/SkinController.php';

use Symfony\Component\HttpFoundation\Request;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin");
header('P3P: CP="CAO PSA OUR"');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}

$app->register(
    new Silex\Provider\MonologServiceProvider(),
    array(
        'monolog.logfile' => 'php://stderr',
    )
);

$app->register(
    new Silex\Provider\DoctrineServiceProvider(),
    array(
        'db.options' => array(
            'driver' => 'pdo_mysql',
            'dbname' => 'heroku_8b6326a19fa3ac5',
            'user' => 'bce267e06beb0b',
            'password' => 'b4ae5a15',
            'host' => "us-cdbr-iron-east-02.cleardb.net",
        )
    )
);

$app->register(
    new Silex\Provider\SessionServiceProvider,
    array(
        'session.storage.save_path' => dirname(__DIR__) . '/tmp/sessions'
    )
);

$app->before(
    function (Request $request) use ($app) {
        $request->getSession()->start();
    }
);

$app->get(
    "/",
    function () use ($app) {
        return json_encode(
            [
                'ok' => false,
                'msg' => 'You do not have permission to access this page.'
            ]
        );
    }
);

$app->run();
