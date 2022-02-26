<?php
  session_start();

  try {
    if (isset($_SESSION['rol'])) {
      $rol = $_SESSION['rol'];

      if ($rol == 2) {
        throw new Exception();
      }
    } else {
      throw new Exception();
    }
  } catch (Exception $e) {
    include '../helpers/auth.php';

    Auth::verifyRol();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear usuario</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/crud/crear.css">
</head>
<body>
  <?php include '../header.php'; ?> 
  
  <section class="container">
    <form action="#" method="post">
      <label>Nombre</label>
      <input class="input" placeholder="Nombre" name="nombre" type="text" required maxlength=100>
      <label>Cedula</label>
      <input class="input" placeholder="Cedula" name="cedula" type="text" required maxlength=10>
      <label>Direccion</label>
      <input class="input" placeholder="Direccion" name="direccion" type="text" required maxlength=200>
      <label>Telefono</label>
      <input class="input" placeholder="Telefono" name="telefono" type="tel" required maxlength=13>
      <label>Correo</label>
      <input class="input" placeholder="Correo" name="correo" type="email" required maxlength=100>
      <label>Contraseña</label>
      <input class="input" placeholder="Contraseña" name="contrasena" type="password" required>
      <label>Rol</label>
      <select class="input" placeholder="Rol" name="rol" required>
        <option value=1>Administrador</option>
        <option selected="selected" value=2>Cajero</option>
      </select>

      <p class="error">
        <?php
          include '../helpers/database.php';

          if (
            isset($_POST['nombre']) 
            && isset($_POST['cedula'])
            && isset($_POST['direccion'])
            && isset($_POST['telefono'])
            && isset($_POST['correo'])
            && isset($_POST['contrasena'])
            && isset($_POST['rol'])
          ) {
            $nombre = $_POST['nombre'];
            $cedula = $_POST['cedula'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $rol = $_POST['rol'];

            try {
              $database = new Database();

              $database->insert(
                "insert into usuarios values (null, '$nombre', '$cedula', '$direccion', '$telefono', '$correo', '$contrasena', $rol)"
              );
              
              header('Location: ../usuarios.php');
            } catch (Exception $e) {
              echo "Hay un error en los datos proporcionados";
            }
          }
        ?>
      </p>

      <input class="button fullWidth" type="submit" value="Enviar">
    </form>
  </section>
</body>
</html>