<?php
session_start();
 include('header.php'); 

 if(!(isset($_SESSION['id']))){
     $_SESSION['message'] = "Por favor ingresá a nuestra plataforma";
    header("Location: login.php"); 
}
 ?>

 

<?php


if (isset($_POST['name'])&& isset($_POST['email']) && isset($_POST['message'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    
    include('SendMail.php');
    $send = new SendMail();
    $send->sendInvitation($email, $name, $message);

    }

?>

<div id="sendMail" class="card mx-auto p-5 m-5">
        <form method= "POST" >
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <h3 for="name" class="alert-heading font-weight-bolder">Nombre</h3>
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="userHelp" placeholder="Ingrese su nombre" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <h3 for="email" class="alert-heading font-weight-bolder">Email</h3>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Ingrese su mail" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <h3 for="message" class="alert-heading font-weight-bolder">Mensaje</h3>
                    <textarea class="form-control" id="message" name= "message" rows="3" required>
Hola, te quiero invitar a formar parte de mi listado de tareas, registrate para ver que tareas tenes asignadas
                    </textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block font-weight-bolder custom-bt">Enviar Invitacion</button>
            </div>
        </form>
    </div>

    <?php include('footer.php'); ?>
