<?php

require_once __DIR__ . '/../../framework/fw.php';

app($_SERVER, realpath(__DIR__ . '/../pages'), [
    '@\A/\z@' => function () {
        header("Location: /index.php");
    },
    '@\A/users/(?<user_id>\d+)/books\z@' => function (array $param) {
        ?>
        <h1>蔵書一覧</h1>
        <p>こんにちは <?= htmlspecialchars($param['user_id']) ?>さん</p>
        <?php
    },
    '@\A/now\z@' => function () {
        echo date('Y-m-d H:i:s');
    },
    '@\A/file_upload\z@u' => function () {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include __DIR__ .'/upload.php';
            return;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            copy($_FILES['file']['tmp_name'], __DIR__ . '/../pages/' . $_FILES['file']['name']);

            http_response_code(301);
            header("Location: /{$_FILES['file']['name']}");
            return;
        }
    },
]);
