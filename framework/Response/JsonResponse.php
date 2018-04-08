<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 08.04.18
 * Time: 19:00
 */

namespace Framework\Response;


use Zend\Diactoros\Response\JsonResponse as DiactorosJsonResponse;

class JsonResponse extends DiactorosJsonResponse
{
    public function __construct(array $data, int $code = 0, string $message = '')
    {
        $response = [
            'status' => ($code === 0) ? 'ok' : 'error',
            'code' => $code,
            'data' => $data,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        parent::__construct($response);
    }
}