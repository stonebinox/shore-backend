<?php

/**
 * Controller for zones
 * 
 * @author Anoop S <anoop.santhanam@gmail.com>
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->get(
    "/zones",
    function () use ($app) {
        $zones = ["face", "under eye", "lips", "body", "feet", "palm"];
        $response = ['ok' => true, 'msg' => '', 'data' => $zones];

        return json_encode($response);
    }
);
