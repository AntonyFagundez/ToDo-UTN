<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!--- BOOTSTRAP4 --->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--- FONT AWESOME --->
    <script src="https://kit.fontawesome.com/0571b40750.js" crossorigin="anonymous"></script>
    <!--- Material Design -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<style>
    body{
        background-color: rgb(51, 119, 255)
    }
    .custom-login {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    .form {
        width: 450px;
    }
    #sendMail {
            padding: 100px;
            width: 50%;
            height: 50%;
            
        }
        h3.alert-heading.font-weight-bolder {
            color: rgb(51, 119, 255);
            text-shadow: 10px

        }
        button.btn.btn-primary.btn-lg.btn-block.font-weight-bolder.custom-bt {
            background-color: rgb(51, 119, 255);
            color: rgba(255, 255, 255, 0.9)
        }
        .alert-custom{
          background-color:rgb(26, 24, 24);
          color:#fff;
          height: 50px;
        }

        #snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}

</style>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <span class="navbar-brand mb-0 h1" aria-disabled="true" href="">Tareas</span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<?php if(!($_SERVER["REQUEST_URI"] == "/UTN/login.php" || ($_SERVER["REQUEST_URI"]== "/UTN/signup.php") )) { ;?>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link <?php if ($_SERVER["REQUEST_URI"]== "/UTN/main.php") { echo "disabled"; } ?>" href="main.php" aria-disabled="<?php if ($_SERVER["REQUEST_URI"]== "/UTN/main.php") { echo "true"; } ?>">Tareas Generales</a>
      </li>
      <?php if(isset($_SESSION['user'])) { ?>
      <li class="nav-item">
        <a class="nav-link" href="main.php?user=<?php echo $_SESSION['user']; ?>">Tareas Asignadas </a>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" href="invitar.php">Invitar </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cuenta
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="user.php">Cambiar contraseña</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="login.php">Salir</a>
        </div>
      </li>
    </ul>
        <!-- Verifica la Url en donde esta ubicado el header para mostrar el filtro o no -->
        <!-- Revisar || substr_compare(parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY),'search',0,6)) -->
        <?php if (parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) == "/UTN/main.php"  )  { 
          if(!isset($_SESSION['id'])){
            header('Location: login.php');
          } ?>

        <form class="form-inline my-2 my-lg-0" method="GET" >
            <input class="form-control mr-sm-2" type="search" placeholder="Filtrar por titulo"
             aria-label="Search" name="search" required>
            <button id='filter' class="btn btn-dark my-2 my-sm-0"
            <?php if (isset($_SESSION['filtroaplicado'])){ 
              echo "disabled";
             } ?>
             type="submit">
            <i class="fas fa-filter"></i>
            </button>
        </form>

        <?php } ?>

<?php } ?>
  </div>
</nav>

