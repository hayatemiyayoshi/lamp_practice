 <!-- エラーの数だけ回す -->
<?php foreach(get_errors() as $error){ ?>
   <!-- エラーを表示する -->
  <p class="alert alert-danger"><span><?php print $error; ?></span></p>
<?php } ?>
 <!-- 完了メッセージの数だけ回す -->
<?php foreach(get_messages() as $message){ ?>
   <!-- 完了メッセージを表示する -->
  <p class="alert alert-success"><span><?php print $message; ?></span></p>
<?php } ?>