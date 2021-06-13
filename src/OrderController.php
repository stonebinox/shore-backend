<?php

/**
 * Controller for orders
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

require __DIR__ . "/../models/Product.php";
require __DIR__ . "/../models/Order.php";
require __DIR__ . "/../models/OrderItem.php";

$app->get(
    "/order/{orderId}",
    function ($orderId) use ($app) {
        $response = ['ok' => false, 'msg' => 'You do not have permission to access this page.'];

        $order_model = new Order($orderId);

        $order = $order_model->getOrder();

        if (!empty($order)) {
            $response['ok'] = true;
            $response['msg'] = '';
            $response['data'] = $order;
        }

        return json_encode($response);
    }
);
