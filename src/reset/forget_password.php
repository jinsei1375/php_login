<?php 

  require_once('../functions.php');

  // formに埋め込むcsrf tokenの生成
  if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
  }

  // csrf tokenを取得
  $csrfToken = filter_input(INPUT_POST, '_csrf_token');
  $email = filter_input(INPUT_POST, 'email');


  if(!empty($_POST)) {
    $user= getUserInfoByEmail($_POST['email']);
    if(!$user) {
      $message = 'このメールアドレスの会員は存在しません。';
    } else {

      // password reset token生成
      $passwordResetToken = bin2hex(random_bytes(32));

      $sql = 'UPDATE `users` SET `reset_token` = :reset_token, `reset_token_sent_at` = :reset_token_sent_at WHERE `email` = :email';
      $dbh = db_connect();
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
      $stmt->bindValue(':reset_token', $passwordResetToken, \PDO::PARAM_STR);
      $stmt->bindValue(':reset_token_sent_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
      $stmt->execute();


      $url = "http://localhost:8888/reset/show_reset_password.php?token={$passwordResetToken}";
      $subject =  'パスワード再設定用のURLを付与しました。';
      $body = <<<EOD
          パスワード再設定用のURLを付与しました。

          24時間以内に下記URLへアクセスし、パスワードを再設定してください。
          {$url}
          EOD;

      $headers = "From : hoge@hoge.com\n";
      $headers .= "Content-Type : text/plain";

      if(mb_send_mail($email, $subject, $body, $headers)) {
        header('Location: ../email_sent.php');
        exit();
      }
    }
  }
  require_once '../parts/header.php';
  require_once './forget_password_form.php';
?>