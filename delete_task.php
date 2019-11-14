<?php
    include("connection.php");

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query= "DELETE FROM task where id = $id";

        $result = mysqli_query($conn, $query);

        if(!$result){
            $_SESSION['message'] = "Algo ha ocurrido :(";
        }
        $_SESSION['message'] = "Tarea removida correctamente";

    
        header("Location: main.php");
    }
?>