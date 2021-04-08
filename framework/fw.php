<?php

function app(array $request, string $base_dir, array $routes)
{
    $url = parse_url($request['REQUEST_URI'])['path'];

    if (is_file($base_dir . $url)) {
        if (preg_match('@\.php@', $url)) {
            readfile($base_dir . $url);
            include $base_dir . $url;
        } elseif (preg_match('@\.png@', $url)) {
            header('Content-Type: image/png');
            readfile($base_dir . $url);
        } else {
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
