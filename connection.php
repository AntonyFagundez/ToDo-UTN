<?php 
$server= '127.0.0.1';
$usernameDB = 'Antonyy';
$passwordDB = '';
$database = 'todo';
$conn = mysqli_connect($server,$usernameDB,$passwordDB,$database);

    if(!$conn){
        die('Algo ha ocurrido');
    }



session_start();

?>