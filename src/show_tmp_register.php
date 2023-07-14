<?php
session_start();

// formに埋め込むcsrf tokenの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

// 仮登録フォームを読み込む
require_once './tmp_register.php';