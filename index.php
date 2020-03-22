<?php
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	include_once 'includes/magicquotes.inc.php';
	include 'includes/db.inc.php';
	include 'includes/access.inc.php';
	userIsLoggedIn();	
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>...</title>
</head>
<link href="css/bootstrap.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" href="css/mycss.css">
<script src="js/jquery.maskedinput.min.js" type="text/javascript"></script>
<body>
	<div class="container">
	<?php
		if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn'])
		{
			echo '<div class="jumbotron"><h2 class="my-btn" align="center">Наряди вхід користувача</h2>';
			include 'includes/login.html.php';
			//exit();
		}
		else
		{
			echo '<div class="jumbotron"><h2 class="my-btn" align="center">Ввод нарядів</h2>';
			echo '<form method="POST"><input type="hidden" name="action" value="logout"><input class="my-btn" name="ext" type="submit" value="Вихід"/></form>';
		}
    	
       	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])
       	{
            if (isset($_POST["addbtn"]))
            {
	            try
	            {
	            	$result = $pdo->query('SELECT MAX(id) FROM `test`');
					$row = $result->fetch();
					$kol = 1 + $row[0];
      				$sql = "INSERT INTO `test` (id,machine,name) VALUES (:kol,'','')";
      				$s = $pdo->prepare($sql);
      				$s->bindValue(':kol', $kol);
				    $s->execute();
	            }
				catch (PDOException $e)
				{
				  	$error = 'Ошибка добавления записи.';
				   	include 'includes/error.html.php';
				   	exit();
				}
			}
			if (isset($_POST["dele"]))
			{
				$id = key($_POST['dele']);
			  	try
    			{
      				$sql = "DELETE FROM `test` WHERE `id` = ".$id;
      				//$sql = "DELETE FROM `test` WHERE `id` = :id";
      				$s = $pdo->prepare($sql);
      				//$s->bindValue(':id', $id);
				    $s->execute();
      			}
    			catch (PDOException $e)
    			{
      				$error = 'Ошибка удаления записи.';
      				include '/includes/error.html.php';
      				exit();
    			}
			}
	        try
			{
			  	$result = $pdo->query('SELECT * FROM test ORDER BY id');
				echo '<table class="mytable" border="0" class="my-btn">' .
					'<thead>' .
					'<tr>' .
					'<th class="my-btn">№ п/п</th>' .
					'<th class="my-btn">код операції</th>' .
					'<th class="my-btn">назва операції</th>' .
					'<th><form method="POST"><input class="my-btn"  onclick="return confirm(\'Вы уверены, что хотите добавить запись?\')" name="addbtn" type="submit" value="Добавить"/></th>'.
					'</tr>' .
					'</thead>';
			    $nom = 1;
			    foreach ($result as $row)
			    {
			        echo '<tr>' .
						'<td class="my-btn">'.$nom.'</td>'.
						'<td contenteditable="true" js-data-row='.$row['id'].' js-data-column="machine">'.$row['machine'].'</td>'.
						'<td contenteditable="false" js-data-row='.$row['id'].' js-data-column="kod">'.$row['name'].'</td>'.
						'<td><form action="" method="POST"><input class="my-btn" type="submit" onclick="return confirm(\'Вы уверены, что хотите удалить запись?\')" name = dele['.$row['id'].'] value="Удалить"/> </form> </td>'.					'</tr>' .
			            '</tr>';
			        $nom++;
			    }
			    echo '</table>';

?> 
<script>
	$('table.mytable submit').click(function() {
		$(this).fadeOut();
		$(this).fadeIn();
	});
	$('table.mytable tbody td').focusin(function() {
		$(this).css('background', 'white');
	});
	$('table.mytable tbody td').focusout(function() {
		var inputCod = $(this); 
		inputCod.css('background', 'transparent'); 
		$.post('/admin/includes/ajaxtest.php', {
			param1: inputCod.text(),
			param2: inputCod.attr('js-data-row'),
			param3: inputCod.attr('js-data-column')
		},
		function(data) {
			inputCod.parents('tr').find("[js-data-column='kod']").html(data);
		});
	});
</script>
<?php 
//echo "$l=$(this).attr('js-data-row');";
/*echo '	$("';
echo "td[js-data-row='".$l."'][js-data-column='name']";
echo '"';
echo ").css('background', 'red');";*/

			}
			catch (PDOException $e)
			{
			    $error = 'Ошибка выполнения запроса.';
			    include 'includes/error.html.php';
			    exit();
			}
		}
		$pdo = null;
		echo '<br><br><br>';
		?>

		<div><h2 class="my-btn" align="center"><?php

                           $rus_months = array('січня', 'лютого', 'березня', 'квітня', 'травня', 'червня', 'липня', 'серпня', 'вересня', 'жовтня', 'листопада', 'грудня');
                           $days = array('неділя', 'понеділок', 'вівторок', 'середа','четвер', 'п`ятниця', 'субота');
                           $liner = 'Сьогодні: '.$days[date('w')].' '.date('d').' '.$rus_months[date('m')-1].' '.date('Y').' року  ';
	                   		$dat=date('Y');
						if ($dat > '2019') {
							$liner = $liner.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copyright&nbsp;©&nbsp;2019-'.date('Y').', Unknown
 Inc. All rights reserved.';
						}
						else {
							$liner = $liner.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Copyright&nbsp;©&nbsp;2019, Unknown
 Inc. All rights reserved.';	
						}
echo $liner;
                          ?>
    </h2>
</div>
	</div>
</body>
</html>