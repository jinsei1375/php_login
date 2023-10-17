<?php
session_start();

require_once('../functions.php');

// クエリからregister_tokenを取得
$registerToken = filter_input(INPUT_GET, 'token');

// tokenに合致するユーザーを取得
$sql = 'SELECT * FROM `users` WHERE `register_token` = :register_token AND `status` = :status';

// register_tokenが合致するユーザーを取得
$dbh = db_connect();
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':register_token', $registerToken, \PDO::PARAM_STR);
$stmt->bindValue(':status', 0, \PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(\PDO::FETCH_ASSOC);

if (!$user) exit('無効なURLです');

// tokenの有効期間を24時間
$tokenValidPeriod = (new \DateTime())->modify("-24 hour")->format('Y-m-d H:i:s');

// 仮登録が24時間以上前の場合、有効期限切れにする
if ($user['register_token_sent_at'] < $tokenValidPeriod) exit('有効期限切れです');

// formに埋め込むcsrf tokenの生成
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

require_once '../parts/header.php';
require_once './register_form.php';
require_once '../parts/footer.php';