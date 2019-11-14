<?php 
include('connection.php');
 include('header.php');
//Seteo la zona horaria de Argentina
 date_default_timezone_set('America/Argentina/Buenos_Aires');

 if(!isset($_SESSION['id'])){
    $_SESSION['message'] = "Por favor ingresá a nuestra plataforma";
    header('Location: login.php');
}
?>
<?php

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $sql = "SELECT * FROM `task` WHERE `title` LIKE '%$search%'";
    $_SESSION['filtroaplicado'] = $sql;
    //unset($_SESSION['filtroaplicado']);
    $resultTemp = mysqli_query($conn, $sql);
    $numrows=mysqli_num_rows($resultTemp);
    if($numrows == 0){
        $_SESSION['message'] = "mmm, no hemos encontrado tareas parecidas a '$search'";
    }

}else if(isset($_GET['user'])){
    //Las tareas asignadas al usuario
    $user = $_SESSION['user'];
    $sqltemp = "SELECT * from user_asigned WHERE user = '$user'";
    $stringwithId = "";
    $preconsulta = mysqli_query($conn, $sqltemp);
    while($vector_fila = mysqli_fetch_array($preconsulta)){
        $stringwithId = $stringwithId . $vector_fila['id_task']. ',';
    }
    //rtrim borra el ultimo caracter
    $stringwithId = rtrim($stringwithId, ',');
    $sql = "SELECT * FROM task WHERE id_user IN ($stringwithId)";
    $messageEmpty = "mmm, me parece que no tenes tareas asignadas";


    //"SELECT * FROM posts WHERE userid IN (44,44,33,44,33,0)"
}else if(isset($_SESSION['filtroaplicado'])){
    $sql = $_SESSION['filtroaplicado'];
    unset($_SESSION['filtroaplicado']);
}else{
    $sql = "select * from task";
    $messageEmpty = "Aun no hay tareas creadas";
}
$conn = new mysqli('127.0.0.1', 'Antonyy', '', 'todo');
$resultado_consulta = mysqli_query($conn, $sql);

if($resultado_consulta){ 
    
    $numrows=mysqli_num_rows($resultado_consulta);
    if($numrows == 0){
        if(isset($messageEmpty)){

            $_SESSION['message'] = $messageEmpty;
            unset($messageEmpty);
        }

    } 
    if(isset($_SESSION['message'])){
    ?>

            <div id="snackbar"><?php echo $_SESSION['message'] ?></div>

            <script>
            function myFunction() {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
            myFunction()
            </script>

            <?php unset($_SESSION['message']);
    }

}else{
    if(isset($messageEmpty)){
        $_SESSION['message'] = $messageEmpty;
    }else{
        $_SESSION['message'] = "Ha ocurrido un error :(";
    }
    unset($messageEmpty);
    unset($_SESSION['filtroaplicado']);
    header('Location: main.php');
}
?>

<div class="container p-4">

<table class='table table-light table-striped shadow'>
    <thead>
        <tr align="center">
            <th> Titulo </th>
            <th> Descripción </th>
            <th> Prioridad </th>
            <th> Terminado </th>
            <th> Fecha Limite </th>
            <th> Asignado a: </th>
            <th> Más... </th>
        </tr>
    </thead>
    <tbody >
    <?php

    while ($vector_fila = mysqli_fetch_array($resultado_consulta)) {
        //Tomo el id para buscar los usuarios asignados
        $id = $vector_fila["id"];
        $mensajeEstado = "";
        $estado = "";
        $user = $_SESSION['user'];
        $createdBy = $vector_fila["user"];
        //logica para pintar las tareas "vencidas" o cercanas a:
        $fecha_actual = strtotime(date("Y-m-d"));
        $fecha_entrada = strtotime($vector_fila["dead_line"]);
        if(!$vector_fila['is_finish']){
            if($fecha_actual > $fecha_entrada){
                //esta vencida
                $mensajeEstado = "La tarea esta vencida";
                $estado = "bg-danger";
    
            }else if ($fecha_actual == $fecha_entrada){
                //Esta por vencerse
                $mensajeEstado = "La tarea se vence hoy";
                $estado = "bg-warning";
            }else{
                $estado = "";
            }
        }

        $badge = "";
        $dateCreated = date("d-m-Y", strtotime($vector_fila["date_created"]));
        if($vector_fila["priority"] == "Baja"){
            $badge = "success";
        }else if($vector_fila["priority"] == "Media"){
            $badge = "warning";
        }else if($vector_fila["priority"] == "Alta")
            $badge = "danger";
        ?>
        <tr align='center' class="<?php echo $estado; ?>" title="<?php echo "Tarea creada el $dateCreated por $createdBy 
$mensajeEstado"; ?> " >
            <td> <?php echo $vector_fila["title"]; ?> </td>
            <td> <?php echo $vector_fila["description"]; ?> </td>
            <td> 
                <span class="badge badge-pill badge-<?php echo $badge; ?> shadow"><?php echo $vector_fila["priority"];?></span>
            </td>
            <td> 
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck<?php echo $id; ?>" disabled <?php if($vector_fila["is_finish"] == 1){ echo "checked";}?>>
                    <label class="custom-control-label" for="customCheck<?php echo $id; ?>"></label>
                </div> 
            </td>
            <td>  <?php echo $datefinish = $vector_fila["dead_line"]; ?> </td>
            <td> 
            <?php if(isset($vector_fila["id_user"])){
                $id_user_asigned = $vector_fila["id_user"];
                $sql = "SELECT * FROM `user_asigned` WHERE `id_task`= $id_user_asigned";
                $conn = new mysqli('127.0.0.1', 'Antonyy', '', 'todo');
                $resultado_Asignados = mysqli_query($conn, $sql);
                while ($vector_fila_asignados = mysqli_fetch_array($resultado_Asignados)) {
                    $id_user_asigned = $vector_fila_asignados['id'];
                    ?>
                    <div class="container ">
                            <button class="btn" type="button">
                            <?php echo $vector_fila_asignados['user']; ?>
                                <a href="delete_user_asigned.php?id=<?php echo $id_user_asigned; ?>" title="Eliminar Usuario asignado " class="text-dark">
                                <i class="fas fa-times"></i>
                                </a>
                            </button>
                            </div>
                    <?php }
                }else{ ?>
                        
                <?php } ?>
                <div class="dropdown">
                <a class="dropdown-toggle text-muted" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <!-- <i class="fas fa-user-plus"></i> -->
                    <i class="fas fa-plus"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-item">
                    <form action="asign.php?id=<?php echo $id; ?>" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control" name="user" placeholder="Usuario" required>
                    </div>
                    <button class="btn pmd-btn-fab pmd-ripple-effect btn-light pmd-btn-raised float-right shadow" type="submit">
                        <i class="fas fa-plus"></i>
                        </a>
                    </button>
                    </form>
                    </div>
                </div>
                </div>
            </td>
            <td> 
               <a href='edit.php?id=<?php echo $id; ?>' title="Editar" class="text-dark" > 
                <i class="fas fa-edit"></i>
                </a> 
                <a href="delete_task.php?id=<?php echo $id;?>" title="Eliminar" class="text-dark" >
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<div class= "container ">
    <button class="btn pmd-btn-fab pmd-ripple-effect btn-light pmd-btn-raised float-right shadow" type="button">
        <a href="edit.php" class="text-dark">
        <i class="fas fa-plus"></i>
        </a>
    </button>
        </div>
    </div>
</div>

<?php mysqli_close($conn); ?>
</div>
<?php include('footer.php');