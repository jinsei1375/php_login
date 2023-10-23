<?php 
  require_once './parts/header.php';
  require_once 'vendor/autoload.php';
  use Carbon\Carbon;  

  $fistDt = Carbon::parse('2023-10-20');
  $secondDt = Carbon::parse('2024-01-20');

  $now = Carbon::now();

  echo $now->isoFormat('YYYY/MM/DD HH:mm') . "<br>";
  echo $now->format('Y/M/D') . "<br>";

  echo $fistDt->diffInSeconds($secondDt) . "<br>";
  echo $fistDt->diffInMinutes($secondDt) . "<br>";
  echo $fistDt->diffInHours($secondDt) . "<br>";
  echo $fistDt->diffInDays($secondDt) . "<br>";
  echo $fistDt->diffInWeeks($secondDt) . "<br>";
  echo $fistDt->diffInMonths($secondDt) . "<br>";
  echo $fistDt->diffInYears($secondDt) . "<br>";
?>
  <main>
    <div class="wrapper">
      <section class="text-gray-600 body-font relative">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">トップページ</h1>
          </div>
        </div>
      </section>
    </div>
  </main>
<?php require_once './parts/footer.php'; ?>