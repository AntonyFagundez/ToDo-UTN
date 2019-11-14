<?php include('connection.php'); ?>

<?php 

if(!isset($_GET['id'])){
    header('Location: main.php');
}else{

    $id_user = $_GET['id'];
    $sql= "DELETE FROM user_asigned where id = $id_user";

    $result = mysqli_query($conn, $sql);

    if($result){
        $_SESSION['message'] = "Usuario desasignado";
        header('Location: main.php');
    }else{
        $_SESSION['message'] = "Ha ocurrido un Error";
    }
    
}



?>