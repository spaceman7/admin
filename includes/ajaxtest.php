<?php
  // файл http://hostname/ajaxtest.php
  include 'db.inc.php';
  $column = $_POST['param3'];
  $znach = $_POST['param1'];
  $id = $_POST['param2'];
  try
  {   
		$sql = "UPDATE `test` SET ".$column." = '".$znach."' where id = ".$id;
		$s = $pdo->prepare($sql);
		$s->execute();
		$sql="SELECT `name` FROM `norma` WHERE kod='".$znach."'";
		$result = $pdo->query($sql);
		$row = $result->fetch();
		$sql = "UPDATE `test` SET `name`='".$row[0]."' WHERE id=".$id;
		$s = $pdo->prepare($sql);
		$s->execute();
		echo $row['name'];
  }
  catch (PDOException $e)
  {
      $error = 'Помилка бази даних.';
      include 'error.html.php';
      еxit();
  }
$pdo = null;
?>
