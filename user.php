<?php 
include('connection.php');

if(!(isset($_SESSION['id']))){
  $_SESSION['message'] = "Por favor ingresá nuevamente a nuestra plataforma";
  header("Location: login.php");
}else{
    $id = $_SESSION['id'];
    $sql = "SELECT email FROM user WHERE id='$id'";
    $response = mysqli_query($conn, $sql);
    while ($result = mysqli_fetch_array($response)) {
        
        $emailUser = $result['email'];
    }
}


if(isset($_POST['newpassword'])){
    $id = $_SESSION['id'];
    $sql = "SELECT password, email FROM user WHERE id='$id'";
    $response = mysqli_query($conn, $sql);

while ($result = mysqli_fetch_array($response)) {
    $password = $_POST['password'];
    $passwordEncript = $result['password'];
    $emailUser = $result['email'];

    $areSame = password_verify ($password, $passwordEncript);
    //Si las contraseñas coinciden procede a cambiar la contraseña
    if($areSame){

        $newpassword = $_POST['newpassword'];
        $newpassword = password_hash($newpassword, PASSWORD_BCRYPT);
        $sql = "UPDATE user SET `password`='$newpassword' WHERE `id`=$id";
        $response = mysqli_query($conn, $sql);
        if($response){
            $_SESSION['message'] = "Se ha cambiado su contraseña satisfactoriamente";
            header("Location: main.php");
        }else{
          $_SESSION['message'] = "algo ha ocurrido :( ";
            header("Location: main.php");
        }
        
    }else {
      $_SESSION['message'] = "Revisa tu confirmación de contraseña";
    }
}
}


?>
<?php include('header.php'); ?>
<!-- Logica de mensaje al usuario  -->
<?php if(isset($_SESSION['message'])){  ?>

            <div id="snackbar"><?php echo $_SESSION['message'] ?></div>

            <script>
            function myFunction() {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
            myFunction()
            </script>

            <?php unset($_SESSION['message']); } ?>

<title>Registro</title>

<div class="container ">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5 shadow">
            <div class="card-body">
            <form class="form-signin" method="POST" >
              <div class="form-group">
              <form method="POST">
              <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label text-muted">Email</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $emailUser; ?>">
                </div>
                </div>
                <input type="password" id="user" class="form-control" name="password" placeholder="Confirme Contraseña" required autofocus>
              </div>
              <div class="form-group">
                <input type="password" id="last_name" class="form-control" name="newpassword" placeholder="Ingrese nueva Contraseña" required>
              </div>
              <button class="btn btn-lg btn-primary btn-block" type="submit">Confirmar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include('footer.php'); ?>