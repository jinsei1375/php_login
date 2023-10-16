<?php 

  require_once('../functions.php');
  session_start();
  if(!isset($_SESSION['is_login'])) {
    header('Location: ../index.php');
    exit();
  }
  require_once '../parts/header.php';

?>
  <main>
    <div class="wrapper">
      <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">マイページ</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">ログイン成功</p>
            <p><?php echo $_SESSION['email']; ?></p>
          </div>
        </div>
      </section>
    </div>
  </main>
<?php require_once '../parts/footer.php'; ?>