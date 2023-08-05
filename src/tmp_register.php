<?php 

  require_once('./db_connect.php');

  // formに埋め込むcsrf tokenの生成
  if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
  }

  // csrf tokenを取得
  $csrfToken = filter_input(INPUT_POST, '_csrf_token');
  $email = filter_input(INPUT_POST, 'email');


  if(!empty($_POST)) {
    $sql = "select count(id) from users where email=:email";
    $dbh = db_connect();
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    if($count['count(id)'] > 0 ) {
      $error['email'] = 'このメールアドレスはすでに使われています。';
    }
    if(!isset($error)) {

      // register token生成
      $registerToken = bin2hex(random_bytes(32));

      $dbh = db_connect();
      $stmt = $dbh->prepare("INSERT INTO users (email, register_token, register_token_sent_at) VALUES (:email, :register_token, :register_token_sent_at)");
      $stmt->bindValue(':email', $email, PDO::PARAM_STR);
      $stmt->bindValue(':register_token', $registerToken, PDO::PARAM_STR);
      $stmt->bindValue(':register_token_sent_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
      $stmt->execute();


      $url = "http://localhost:8888/show_register_form.php?token={$registerToken}";
      $subject =  '仮登録が完了しました';
      $body = <<<EOD
          会員登録ありがとうございます！

          24時間以内に下記URLへアクセスし、本登録を完了してください。
          {$url}
          EOD;

      $headers = "From : hoge@hoge.com\n";
      $headers .= "Content-Type : text/plain";

      if(mb_send_mail($email, $subject, $body, $headers)) {
        header('Location: email_sent.php');
        exit();
      }
    }
  }
  require_once './parts/header.php';
?>
  <main>
    <div class="wrapper">
      <h1 class="text-center">仮登録</h1>
      <div class="form-wrap row justify-content-center">
        <form action="tmp_register.php" method="POST" class="p-4 col-6">
          <div class="mb-3">
            <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" value="<?php echo (isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : ''); ?>" required>
            <?php if(!empty($error['email'])): ?>
              <p class="text-danger"><?php echo $error['email']; ?></p>
            <?php endif; ?>
          </div>
          <button type="submit" class="btn btn-primary">仮登録する</button>
        </form>
      </div>
    </div>
  </main>
<?php require_once './parts/footer.php'; ?>