<?php

/**
 * Controller for skin types based on zones
 * 
 * @author Anoop S <anoop.santhanam@gmail.com>
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->get(
    "/skin-types",
    function (Request $request) use ($app) {
        $response = ['ok' => false, 'msg' => 'Something went wrong. Try again later.'];

        if ($skinType = $request->get('skinType')) {
            $validSkinType = true;

            switch (strtolower(($skinType))) {
                case "face":
                    $skinTypes = ["oily", "dry", "combination"];
                    break;
                case "under eye":
                    $skinTypes = ["puffy", "dark"];
                    break;
                case "body":
                    $skinTypes = ["dry", "normal"];
                    break;
                case "palm":
                    $skinTypes = ["dry", "sweaty"];
                    break;
                case "lips":
                case "feet":
                    $skinTypes = [];
                    break;
                default:
                    $validSkinType = false;
                    break;
            }

            if ($validSkinType) {
                $response['ok'] = true;
                $response['msg'] = '';
                $response['data'] = $skinTypes;
            } else {
                $response['msg'] = 'Invalid zone selection';
            }
        }

        return json_encode($response);
    }
);
