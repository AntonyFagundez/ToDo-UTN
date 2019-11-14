<?php
// session_start();
// session_destroy();
session_start();
unset($_SESSION['id']);
if(isset($_POST['email'])){


    $correcto = isset($_POST['user']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']);
    if($correcto){

        $message="";

        if(isset($_POST['user'])){
            $user = trim($_POST['user']);
            if(!empty($user)){
                $user = $_POST['user'];
            }else{
                $message .= "l Usuario no puede estar vacío";
            }
        }

        if(isset($_POST['password'])){
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_BCRYPT);
        }else{
            $message .= "La contraseña no puede estar vacía";
        }

        if(isset($_POST['email'])){
            $email = $_POST['email'];
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = $_POST['email'];
          }else{
            $message .= "el mail debe estar en formato correcto";
          }
        }

        if(isset($_POST['first_name'])){
            $firstName = trim($_POST['first_name']);
            if(!empty($name)){
                $firstName = $_POST['first_name'];
            }else{
                $message .= "El nombre no puede estar vacío";
            }
        }

        if(isset($_POST['last_name'])){
            $lastName = trim($_POST['last_name']);
            if(!empty($name)){
                $lastName = $_POST['last_name'];
            }else{
                $message .= "El Apellido no puede estar vacío";
            }
        }

        $userunique = 1;
        $mailunique = 1;
        $conn = mysqli_connect("localhost","Antonyy","","todo");
        $query=mysqli_query($conn, "SELECT * FROM user WHERE user='$user'");
        $numrows=mysqli_num_rows($query);
        if($numrows > 0){
          $userunique = 0;
          $_SESSION['message'] = "El usuario no está disponible";
        }

        $query=mysqli_query($conn, "SELECT email FROM user WHERE email='$email'");
        $numrows=mysqli_num_rows($query);
        if($numrows > 0){
          $mailunique = 0;
          $_SESSION['message'] = "mm, me parece que estás registrado";
        }


        if($userunique && $mailunique){
          $sql = "INSERT INTO user (`user`, `password`, `email`, `first_name`, `last_name`) VALUES ('$user','$password','$email','$firstName', '$lastName')";

        $conn = mysqli_connect("localhost","Antonyy","","todo");
        $response = mysqli_query($conn, $sql);
        if(!$response){
          $_SESSION['message'] = "Ha ocurrido un error";
        }else{
          $_SESSION['user'] = $user;
          $_SESSION['message'] = "Por favor ingrese su contraseña.";
          include('SendMail.php');
          $send = new SendMail();
          $send->sendWelcome($email,$user);
        }

        }
    }

}



if(isset($_POST['user']) && isset($_POST['password']) && !(isset($_POST['email'])) ){

    $user = $_POST['user'];
    $password = $_POST['password'];

    $sql = "SELECT id, user, password FROM user WHERE user='$user'";

    $conn = mysqli_connect("localhost","Antonyy","","todo");
    $response = mysqli_query($conn, $sql);

    while ($vector_fila = mysqli_fetch_array($response)) {
        $passwordEncript = $vector_fila['password'];
        
        $areSame = password_verify ($password, $passwordEncript );
        if($areSame){
            $id = $vector_fila['id'];
        }else{
          $_SESSION['message'] = "Contraseña y/o usuario erroneo";
        }
    }

    if($areSame){
        $_SESSION['id'] = $id;
        $_SESSION['user'] = $user;
        header("Location: main.php");
        $_SESSION['message'] = "Bienvenido $user";
    }else{
        $_SESSION['message'] = "Contraseña y/o usuario erroneo";
        header("Location: login.php");
    }

}

// if(isset($areSame)){
  
//     if($areSame){
//       session_start();
//       $_SESSION['id'] = $id;
//       $_SESSION['user'] = $user;
//       $_SESSION['message'] = "Bienvenido $user";
//       header("Location: main.php");
//     }else{
//       $_SESSION['message'] = "Contraseña y/o usuario erroneo";
//       header("Location: login.php");
//     }
// }

?>

<?php include('header.php') ?>
<html>
<?php if (isset($_SESSION['message'])){ ?>
  <div class="container fixed-bottom fade in alert alert-custom alert-dismissible fade show w-50" role="alert">
    <?php echo $_SESSION['message']; ?>
    <button type="button" class="close align-middle" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
  </div>
<?php unset($_SESSION['message']); } ?>

  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5 shadow">
        <div class="container mt-3 mb-0">
        <h4 class=" container text-center display-10">Iniciar Sesion en Tareas</h4>
        </div>  
            <div class="card-body">
            <form class="form-signin" method="POST" >
              <div class="form-group">
                <input type="text" id="user" class="form-control" name="user" placeholder="Usuario" value="<?php if(isset($_SESSION['user'])){ echo $_SESSION['user']; } ?>" required autofocus>
              </div>

              <div class="form-group">
                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Contraseña" required>
              </div>


              <button class="btn btn-primary btn-lg btn-block font-weight-bolder custom-bt" type="submit">Iniciar sesión</button>
            </form>
          </div>
        </div>
      </div>


      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5 shadow">
        <div class="container mt-3 mb-0">
        <h4 class=" container text-center display-10">Registrarse en Tareas</h4>
        </div>  
            <div class="card-body">

            <form class="form-signin" method="POST" >
              <div class="form-group">
                <input type="text" id="user" class="form-control" name="user" placeholder="Usuario" required autofocus>
              </div>
              <div class="form-group">
                <input type="email" id="email" class="form-control" name="email" placeholder="john_wick@email.com" required>
              </div>

              <div class="form-group">
                <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Contraseña" required>
              </div>
              <div class="form-group">
                <input type="text" id="first_name" class="form-control" name="first_name" placeholder="Nombres" required>
              </div>
              <div class="form-group">
                <input type="text" id="last_name" class="form-control" name="last_name" placeholder="Apellidos" required>
              </div>
              <button class="btn btn-primary btn-lg btn-block font-weight-bolder custom-bt" type="submit">Registrarse</button>
            </form>
          </div>
        </div>
      </div>



    </div>
  </div>




</body>



</html>

<?php include('footer.php') ?>