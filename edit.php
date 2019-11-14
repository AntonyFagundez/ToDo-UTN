<?php
 include('connection.php');
 include('header.php'); ?>

<?php


$id = 0;
$title =  "";
$description = "";
$user =  "";
$priority = "low";
$is_finish = 0;
$buttonMessage = "Añadir Tarea";
// INSERT INTO `task`(`id`, `title`, `description`, `user`, `priority`, `is_finish`, `dead_line`, `date_created`, `id_user`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])
$conn = new mysqli('127.0.0.1', 'Antonyy', '', 'todo');

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $resultado_consulta = mysqli_query($conn, "select * from task where `id`= $id");
    if($registro = mysqli_fetch_array($resultado_consulta)){
        $title =  $registro["title"];
        $description =  $registro["description"];
        $user =  $registro["user"];
        $priority =  $registro["priority"];
        $is_finish = $registro["is_finish"];
        $id = $registro["id"];
        $date = $registro["dead_line"];
        $date = date("Y-m-d", strtotime($date));
        $buttonMessage = "Actualizar";
    }

}

?>
<?php
    if(empty($_POST)==false){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $user =  $_SESSION['user'];
        $priority =  $_POST["priority"];

        $dead_line = $_POST["dead_line"];
        $dead_line = strtotime($dead_line);
        $date = date("Y-m-d", $dead_line);
        $date = (string) $date;
        //Condicional para el check del formulario
        if(isset($_POST["is_finish"])){
            $is_finish = 1;
        }else {
            $is_finish = 0;
        }

        $sql="";
        echo $user;
        if ($buttonMessage == "Actualizar"){
            $sql = "UPDATE task SET `title`='$title', `description`='$description', `priority`='$priority', `is_finish`='$is_finish', `dead_line`='$date' WHERE `id`=$id";
            $_SESSION['message'] = "Tarea $title modificada";
        }else{
            $dateNow = date("y-m-d");
            $sql="INSERT INTO `task`( `title`, `description`,`user`, `priority`, `is_finish`, `dead_line`, `date_created`) VALUES ('$title','$description', '$user', '$priority', '$is_finish', '$date','$dateNow')";
            $_SESSION['message'] = "Se ha creado la tarea $title";
        }
        
        $respuesta = mysqli_query($conn, $sql);
        if($respuesta){
             header("Location: main.php");

        }

    }
?>
<div class="container mt-1 w-25">
    <div class="card mx-auto p-4 m-4">
        <form method="POST">
            <div class="form-row">
            <div class="form-group w-100">
                    <input type="text" name="title" class="form-control" value="<?php echo $title; ?>" id="title" placeholder="Título de mi Tarea">
            </div>
            </div>
            <div class="form-row">
                    <textarea class="form-control" name="description" id="description" placeholder="Introduzca una descripción de su tarea" required><?php echo trim($description);?></textarea>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                    </div>
                </div>
                <div class="form-group">
                            <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect01">Prioridad</label>
                                    </div>
                                <select class="custom-select" id="inputGroupSelect01" name="priority">
                                    <option selected>
                                        <?php if($priority == "Baja"){ echo "Baja"; 
                                        }else if($priority == "Media"){ echo "Media"; 
                                        }else if($priority == "Alta"){ echo "Alta"; 
                                        }else {echo "Seleccione..."; }
                                        ?>
                                    </option>
                                    <option value="Baja">Baja</option>
                                    <option value="Media">Media</option>
                                    <option value="Alta">Alta</option>
                                </select>
                            </div>
                </div>
            <div class="form-group">
                <label for="dead_line">Fecha Tope</label>
                <input type="date" name="dead_line" class="form-control" id="dead_line" value="<?php echo $date; ?>" >
            </div>

            <div class="form-group">

                </div>

            <div class="form-check form-group">
                <label class="form-check-label">
                    <input class="form-check-input" name="is_finish" <?php if($is_finish==1){ echo "checked"; }?> type="checkbox" value="true">
                    ¿Está Finalizada? 
                </label>
            </div>
            <button type="submit" class="btn btn-dark btn-lg btn-block font-weight-bolder custom-bt"><?php echo $buttonMessage; ?></button>
        </form>
    </div>
</div>


<?php include('footer.php'); ?>