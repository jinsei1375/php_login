<?php

  $title = 'ログイン';
  $path = '../';

  $header_path = $path . './parts/header.php';
  include $header_path;

?>

<div class="col-12">
  <form>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="is_login" value="1">
    <input type="text" id="name" class="fadeIn second" name="name" placeholder="ユーザー名">
    <input type="password" id="password" class="fadeIn third" name="password" placeholder="パスワード">
    <input type="submit" class="fadeIn fourth" value="ログイン">
  </form>
</div>