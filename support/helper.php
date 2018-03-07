<?php

if (! function_exists('filter')) {
    function filter(&$value, $default = '', $callback = 'htmlspecialchars')
    {
        if ( ! isset($value)) {
            return $default;
        }

        if (is_array($value)) {
            $value = array_map_recursive($callback, $value);
        } else {
            $value = call_user_func($callback, $value);
        }

        return $value;
    }
}

if (! function_exists('http_request')) {
    function http_request($url, $post_data = null, $timeout = 3)
    {
        if ( ! extension_loaded('curl')) {
            return false;
        }

        $ch = curl_init($url);

        $ar_url = parse_url($url);
        if ($ar_url['scheme'] == 'https') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ( ! empty($post_data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            if (is_array($post_data)) {
                $post_data = http_build_query($post_data);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        $data = curl_exec($ch);
        curl_close($ch);

        if ( ! $data) {
            return false;
        }

        return $data;
    }
}

if (! function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && starts_with($value, '"') && ends_with($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (! function_exists('starts_with')) {
    function starts_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('ends_with')) {
    function ends_with($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if (substr($haystack, -strlen($needle)) === (string)$needle) {
                return true;
            }
        }

        return false;
    }
}