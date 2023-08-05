<?php 

  require_once('../db_connect.php');
  session_start();
  if(!isset($_SESSION['is_login'])) {
    header('Location: ../index.php');
    exit();
  }
  require_once '../parts/header.php';

?>
  <main>
    <div class="wrapper">
      <h1 class="text-center">マイページ</h1>
      <p class="text-center">ログイン成功</p>
      <p><?php echo $_SESSION['email']; ?></p>
    </div>
  </main>
<?php require_once '../parts/footer.php'; ?>