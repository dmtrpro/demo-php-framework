<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 18:20
 */

namespace Framework\Controller;


use Zend\Diactoros\Response\JsonResponse;

class JsonController
{
    public static $messages = [];

    protected function jsonResponse(array $data, int $code = 0, string $message = '')
    {
        $response = [
            'status' => ($code === 0) ? 'ok' : 'error',
            'code' => $code,
            'data' => $data,
        ];

        if ($message) {
            $response['message'] = $message;
        } elseif (static::$messages[$code]) {
            $response['message'] = static::$messages[$code];
        }

        return new JsonResponse($response);
    }
}