<?php

namespace SimpleApi\Http;

class Response
{
    /**
     * 响应正确的API
     * @param array|string|null $data
     * @param int $code
     * @param string $msg
     * @return Response
     */
    public static function respond($data = [], int $code = 0, string $msg = 'success')
    {
        self::setHeader();
        echo json_encode(['code' => $code, 'data' => $data, 'msg' => $msg]);
    }

    /**
     * 响应错误的API
     * @param string $msg
     * @param int $code
     * @return Response
     */
    public static function fail(string $msg, int $code = null)
    {
        self::setHeader();
        http_response_code($code);
        echo json_encode(['code' => $code, 'msg' => $msg]);
    }

    /**
     * 设置Header头
     * @return Null
     */
    public static function setHeader()
    {
        header('Content-type: application/json;charset=utf-8');
    }
}
