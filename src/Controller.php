<?php

namespace SimpleApi\Http;

abstract class Controller
{
    /**
     * 调用请求方法前执行事件
     * @return bool
     */
    public function onRequest(?string $action): bool
    {
        return true;
    }

    /**
     * 调用请求方法后执行事件
     * @return Response
     */
    public function afterRequest()
    {
    }
}
