<?php

/**
 * Controller for product types
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

require "../models/Status.php";
require "../models/ProductType.php";

$app->get(
    "/producttypes",
    function () use ($app) {
        $response = ['ok' => false, 'msg' => 'You do not have permission to access this page.'];

        $productType = new ProductType();
        $productTypes = $productType->getProductTypes();

        if (!empty($productTypes)) {
            $response['ok'] = true;
            $response['msg'] = '';
            $response['data'] = $productTypes;
        }

        return json_encode($response);
    }
);
