<?php
//-----
if (isset($_POST['name'])) 
{
    $column = $_POST['name'];
    if ($_POST['name'] == 'date') 
    {
        $newValue = strtotime($_POST['value']);
    } 
    else
    {
        $newValue = $_POST['value'];
    }
    $id = $_POST['pk'];
    $pdo = new PDO('mysql:host=localhost;dbname=hmail', 'hMail', 'hMail20011');
  	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$pdo->exec('SET NAMES "utf8"');
	$sql = "UPDATE `hm_messages_new` SET $column = :newValue where `id` = :id";
	$s = $pdo->prepare($sql);
	$s->bindValue(':newValue', $newValue);
	$s->bindValue(':id', $id);
	$s->execute();
}
//-----
?>