<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 18:20
 */

namespace Framework\Controller;


use Framework\Response\JsonResponse;

class JsonController
{
    public static $messages = [];

    protected function jsonResponse(array $data, int $code = 0, string $message = '')
    {
        if (!$message && static::$messages[$code]) {
            $message = static::$messages[$code];
        }

        return new JsonResponse($data, $code, $message);
    }
}