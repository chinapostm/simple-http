<?php

namespace SimpleApi\Http;

class Request
{
    /**
     * 获取GET参数
     * @param string $key
     * @param string $default
     * @return string|array $param
     */
    public static function get($key = null, $default = null)
    {
        if ($key && !isset($_GET[$key]) && !is_null($default)) {
            return $default;
        }
        $_GET = self::toFilter($_GET);
        $value = $key === null ? $_GET : $_GET[$key];
        if (is_null($value)) {
            return;
        }
        return $value;
    }

    /**
     * 获取POST参数
     * @param string $key
     * @param string $default
     * @return string|array $param
     */
    public static function post($key = null, $default = null)
    {
        if ($key && !isset($_POST[$key]) && !is_null($default)) {
            return $default;
        }
        $_POST = self::toFilter($_POST);
        $value = $key === null ? $_POST : $_POST[$key];
        if (is_null($value)) {
            return;
        }
        return $value;
    }

    /**
     * 过滤风险参数
     * @param array $data
     * @return array $data
     */
    public static function toFilter(array $data): ?array
    {
        return str_replace(['<', '>', '"', "'", '&'], ['&lt;', '&gt;', '&quot;', '&#039;', '&amp;'], $data);
    }

    /**
     * 获取IP地址
     * @param bool $isLong
     * @return string|int IP address
     */
    public static function ip(bool $isLong = false)
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
            $ip  = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ips = explode(',', $ip);
            $key = array_search('unknown', $ips);
            if ($key !== false) unset($ips[$key]);
            $ip = trim($ips[0]);
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        if ($isLong) {
            return $long ? $long : '0000000000';
        } else {
            return $long ? $ip : '0.0.0.0';
        }
    }
}
