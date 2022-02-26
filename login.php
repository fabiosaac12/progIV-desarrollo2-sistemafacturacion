<?php
  session_start();

  if (isset($_GET['cerrar_sesion'])) {
    session_unset();
    session_destroy();

    header('Location: login.php');
  }

  include './helpers/auth.php';
  Auth::verifyRol();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prog IV,   Proyecto 2</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/login.css">
</head>
<body>
  <section class="container">
    <form action="#" method="post">
      <label for="cedula">Cedula</label>
      <input placeholder="Cedula" id="cedula" name="cedula" type="text" required class="input">

      <label for="contrasena">Contraseña</label>
      <input placeholder="Contraseña" id="contrasena" name="contrasena" type="password" required class="input">

      <p class="error">
        <?php
          include './helpers/database.php';

          if (isset($_POST['cedula']) && isset($_POST['contrasena'])) {
            $cedula = $_POST['cedula'];
            $contrasena = $_POST['contrasena'];

            try {
              $database = new Database();

              $result = $database->select("select * from usuarios where cedula=$cedula");
              $user = $result[0];

              $contrasenaHash = $user['contrasena'];

              if (password_verify($contrasena, $contrasenaHash)) {
                $_SESSION['rol'] = $user['rol'];
                $_SESSION['id'] = $user['id'];

                Auth::verifyRol();
              } else {
                throw new Exception();
              }
            } catch (Exception $e) {
              echo "Usuario o contrasena incorrectos";
            }
          }
        ?>
      </p>

      <input type="submit" value="Enviar" class="button fullWidth">
    </form>
  </section>
</body>
</html>