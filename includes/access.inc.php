<?php
session_start();
function userIsLoggedIn()
{
  if (isset($_POST['action']) and $_POST['action'] == 'login')
  {
    if (!isset($_POST['username']) or $_POST['username'] == '' or
      !isset($_POST['kod']) or $_POST['kod'] == '')
    {
      $GLOBALS['loginError'] = 'Не всі поля заповнено';
      return FALSE;
    }

    $kod = hash('sha1',$_POST['username'].$_POST['kod']);

    if (databaseContainsAuthor($_POST['username'], $kod))
    {
      $_SESSION['loggedIn'] = TRUE;
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['kod'] = $kod;
      return TRUE;
    }
    else
    {
      $GLOBALS['loginError'] = 'Пользователь или код введены некорректно.';
      return FALSE;
    }
  }

  if (isset($_POST['action']) and $_POST['action'] == 'logout')
  {
    unset($_SESSION['loggedIn']);
    unset($_SESSION['username']);
    unset($_SESSION['kod']);
    header('Location: . ');
  }

  return false;
}

function databaseContainsAuthor($username, $kod)
{
	global $pdo;
  try
  {
    $sql = "SELECT `kod` FROM `users` WHERE `name` = :username";
    $s = $pdo->prepare($sql);
    $s->bindValue(':username', $username);
    $s->execute();
	$row = $s->fetch();
	if (isset($row[0]) and $row[0] == "")
	{  
      $period = mktime(0, 0, 0, date("m"),   date("d") + 40 ,   date("Y"));
      $period = date('Y-m-d', $period);
      echo $period;
      $sql = "UPDATE `users` SET `kod`= :kod , `period` = :period WHERE `name` = :username";
      $s = $pdo->prepare($sql);
      $s->bindValue(':kod', $kod);
      $s->bindValue(':period', $period);      
      $s->bindValue(':username', $username);
      $s->execute();
      $row[0] = $kod;
    }
	else
	{
		if($row[0] != $kod)
		{
			$row[0] = "";
		}
	}
	if ($row[0] != "")
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
  }
  catch (PDOException $e)
  {
    $error = 'Ошибка поиска пользователя.';
    include 'error.html.php';
    exit();
  }
}