<?php include('connection.php'); 

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $sql= $sql= "UPDATE task SET `id_user`=$id WHERE `id`=$id";

    $resultado_actualizar = mysqli_query($conn, $sql);

    if(!$resultado_actualizar){
        header('Location: main.php');
    }

    if(isset($_POST['user'])){
        $user_asigned = $_POST['user'];
        $sql = "INSERT INTO `user_asigned`( `user`, `id_task`) VALUES ( '$user_asigned',$id)";
        $resultado_consulta = mysqli_query($conn, $sql);
        if($resultado_consulta){
            $_SESSION['message'] = "Usuario asignado";
            header('Location: main.php');
        
        }else{
            $_SESSION['message'] = "Ha ocurrido un Error";
            header('Location: main.php');
        }
    }


}

?>

