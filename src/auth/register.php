<?php
  $title = 'ユーザー登録';
  $path = '../';

  $header_path = $path . './parts/header.php';
  include $header_path;

?>

<div class="col-12">
  <form action="<? echo $path; ?>controller/auth_register.php" method="post">
    <?php if (isset($_SESSION['message'])) : ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error!</strong> <?php echo $_SESSION['message'] ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="text" id="name" class="fadeIn second" name="name" placeholder="ユーザー名" required>
    <input type="email" id="email" class="fadeIn second" name="email" placeholder="メールアドレス" required>
    <input type="password" id="password" class="fadeIn third" name="password" placeholder="パスワード" required>
    <input type="submit" class="fadeIn fourth" value="登録">
  </form>
</div>