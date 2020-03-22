<?php include_once 'helpers.inc.php'; ?>
<div>Будь ласка, введіть ім`я користувача та код</div>
<?php if (isset($loginError)): ?>
<p><?php htmlout($loginError); ?></p>
<?php endif; ?>
    <form action="" method="post" class="my-btn">
      <div>
        <label for="username">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ласкаво просимо:&nbsp;&nbsp; <input type="text" name="username" id="username"></label>
      </div>
      <div>
        <label for="kod">Для входу введіть код:&nbsp;&nbsp;<input type="password"
            name="kod" id="kod"></label>
          <input type="hidden" name="action" value="login">
          <input class="my-btn" type="submit" value="Вхід">
      </div>
    </form>
<?php 
//echo '<br><br><br>';
//$dat=date('Y');
//if ($dat == '2019')
//{
//echo "<div class='my-btn' align='center'> Copyright&nbsp;©&nbsp;2019, Unknown
// Inc. All rights reserved.</div>";
//}
//else
//{
//echo "<div class='my-btn' align='center'>Copyright&nbsp;©&nbsp;2019-".date('Y').", Unknown
// Inc. All rights reserved.';</div>";
//}
?>
