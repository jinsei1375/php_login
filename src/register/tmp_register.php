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
    if(getUserByEmail($_POST['email'], false)) {
      $error['email'] = 'このメールアドレスはすでに使われています。';
    } else { 
      insertTempUser($email);
    }
  }
  require_once '../parts/header.php';
  require_once './tmp_register_form.php';
  require_once '../parts/footer.php';
?>