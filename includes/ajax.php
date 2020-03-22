<?php

include 'db.inc.php';
if (isset($_POST['column'])) {
    $column = $_POST['column'];
    $znach = $_POST['znach'];
    $id = $_POST['id']
    echo $column;
    echo $znach;
    echo $id;
    try
    {   
        $sql = "UPDATE `test` SET :column = :znach where id = :id";
        $s = $pdo->prepare($sql);
        $s->bindValue(':column', $column);
        $s->bindValue(':id', $id);
        $s->bindValue(':znach', $znach);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $error = 'Ошибка изменения записи.';
        include '/error.html.php';
        еxit();
    }
	$pdo = null;
}
else {
        $error = 'Ошибка при изменении записи.';
        include 'error.html.php';
        еxit();
}
?>