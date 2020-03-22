<?php
                echo '<script>';
console.log('jhjhjhj');
                echo '</script>';
    $login=$_POST['login'];
    $pass=$_POST['password'];
    if($login=="1111" && $pass=="2222"){
        echo "Авторизация прошла успешно";
    }
    else{
        echo "Неверно введен логин или пароль";
    }
?>