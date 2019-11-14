<?php include('connection.php'); ?>
<?php include('header.php'); ?>
<div class="card mx-auto p-5 m-5" style="padding: 100px; width: 50%; height: 50%;">

<?php
if(isset($_POST['title'])){
    $title = $_POST['title'];
    $title = trim($title);
    if(!empty($title)){
        $title = $_POST['title'];
    }else{
        $message .= "La tarea no puede contener un titulo vacío";
    }


$description = $_POST['description'];


if(isset($_POST['user'])){
    $user = $_POST['user'];
    $user = trim($title);
    if(!empty($user)){
        $user = $_POST['user'];
    }else{
        $message .= "EL Usuario no puede estar vacío";
    }
}

if(!isset($_POST['priority'])){
    //baja por defecto
    $priority = "Baja";
}else{
    $priority = $_POST['priority'];
}

if(isset($_POST['dead_line'])){
    $dead_line = $_POST['dead_line'];
    if(!$dead_line = "null"){
        $sql = "INSERT INTO task (`title`, `description`, `user`, `priority`,`dead_line`) VALUES ('$title','$description','$user','$priority','$dead_line')";
    }else{
        $sql = "INSERT INTO task (`title`, `description`, `user`, `priority`,`dead_line`) VALUES ('$title','$description','$user','$priority','$dead_line')";
    }
}

$response = mysqli_query($conn, $sql);

if(!$response){
    $_SESSION['message'] = "Ha ocurrido un error.";
}else{
    header("Location: main.php");
}
}
?>




<form  method="POST">
    <div class="form-group">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h3 for="name" class="alert-heading font-weight-bolder">Titulo</h3>
                            <input type="text" class="form-control" name="title" id="name" aria-describedby="userHelp" placeholder="Ingrese el Titulo" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <h3 for="description" class="alert-heading font-weight-bolder">Description</h3>
                            <textarea class="form-control" id="description" name= "description" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h3 for="user" class="alert-heading font-weight-bolder">User</h3>
                    <input type="text" class="form-control" name="user" id="user" aria-describedby="userHelp" placeholder="Ingrese su usuario" required>
                </div>
                <div class="form-group">
                    <h3 for="user" class="alert-heading font-weight-bolder">Prioridad</h3>
                    <div class="form-check form-check-inline ">
                        <input class="form-check-input " type="radio" name="inlineRadioOptions" id="priority" value="low">
                        <label class="form-check-label" for="inlineRadio1">Baja</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="priority" value="medium">
                        <label class="form-check-label" for="inlineRadio2">Media</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="priority" value="high">
                        <label class="form-check-label" for="inlineRadio2">Alta</label>
                    </div>
                </div>
                <div class="form-group">
                    <h3 for="user" class="alert-heading font-weight-bolder">Fecha Tope:</h3>
                    <input type="date" name="dead_line" max="3000-12-31" min="2019-10-19" class="form-control" value="null">
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block font-weight-bolder custom-bt">Enviar</button>
            </div>
        </form>


<?php include('footer.php') ?>