<?php

function app(array $request, string $base_dir, array $routes)
{
    $url = parse_url($request['REQUEST_URI'])['path'];

    if (strpos($url, '..') !== false) {
        http_response_code(404);
        echo 'ないです';
        return;
    }
    if (file_exists($base_dir . $url)) {
        if (preg_match('@\.png@', $url)) {
            header('Content-Type: image/png');
            readfile($base_dir . $url);
        }
        return;
    }

    foreach ($routes as $pattern => $function) {
        if (preg_match($pattern, $url, $params)) {
            $function($params);
            return;
        }
    }

    http_response_code(404);
    echo 'ないです';
}
