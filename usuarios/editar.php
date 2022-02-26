<?php
  session_start();

  try {
    if (isset($_SESSION['rol'])) {
      $rol = $_SESSION['rol'];
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
  <title>Editar usuario</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/crud/editar.css">
</head>
<body>
  <?php include '../header.php'; ?> 

  <?php
    try {
      if (isset($_GET['id'])) {
        $id = $_GET['id'];

        include '../helpers/database.php';
        $database = new Database();

        $user = $database->selectOne("select * from usuarios where id=$id");

        if ($user['rol'] == 0) {
          throw new Exception();
        }

        if ($_SESSION['rol'] == 2) {
          if (!($user['id'] == $_SESSION['id'])) {
            throw new Exception();
          }
        }

        $nombre = $user['nombre'];
        $cedula = $user['cedula'];
        $direccion = $user['direccion'];
        $telefono = $user['telefono'];
        $correo = $user['correo'];
        $contrasena = $user['contrasena'];
        $rol = $user['rol'];
      } else {
        throw new Exception();
      }
    } catch (Exception $e) {
      header('Location: ../usuarios.php');
    }
  ?>
  
  <section class="container">
    <form action="#" method="put">
      <?php
        $disabledCedula = 'disabled';

        if ($_SESSION['rol'] == 0) {
          $disabledCedula = '';
        }

        echo "      
          <input class='input' name='id' type='hidden' value='$id'>
          <label>Nombre</label>
          <input class='input' placeholder='Nombre' name='nombre' type='text' required maxlength=100 value='$nombre'>
          <label>Cedula</label>
          <input class='input' $disabledCedula placeholder='Cedula' name='cedula' type='text' required maxlength=10 value='$cedula'>
          <label>Direccion</label>
          <input class='input' placeholder='Direccion' name='direccion' type='text' required maxlength=200 value='$direccion'>
          <label>Telefono</label>
          <input class='input' placeholder='Telefono' name='telefono' type='tel' required maxlength=13 value='$telefono'>
          <label>Correo</label>
          <input class='input' placeholder='Correo' name='correo' type='email' required maxlength=100 value='$correo'>
          <label>Nueva contraseña (opcional)</label>
          <input class='input' placeholder='Nueva contraseña' name='contrasena' type='password'>
        ";
      ?>
      <?php
        $disabledRol = '';

        if ($_SESSION['rol'] != 0) {
          $disabledRol = 'disabled';
        }

        echo "
          <label>Rol</label>
          <select $disabledRol class='input' placeholder='Rol' name='rol' required>
        ";
      ?>
        <?php 
          if ($rol == 2) {
            echo "
              <option value=1>Administrador</option>
              <option selected='selected' value=2>Cajero</option>
            ";
          } else {
            echo "
              <option selected='selected' value=1>Administrador</option>
              <option value=2>Cajero</option>
            ";
          }
        ?>
      </select>

      <p class="error">
        <?php
          if (
            isset($_GET['nombre']) 
            && isset($_GET['direccion'])
            && isset($_GET['telefono'])
            && isset($_GET['correo'])
            && isset($_GET['contrasena'])
          ) {
            $nombre = $_GET['nombre'];
            $direccion = $_GET['direccion'];
            $telefono = $_GET['telefono'];
            $correo = $_GET['correo'];

            if ($_SESSION['rol'] == 0) {
              $rol = $_GET['rol'];
              $cedula = $_GET['cedula'];
            }

            if ($_GET['contrasena']) {
              $contrasena = password_hash($_GET['contrasena'], PASSWORD_DEFAULT);
            }

            try {
              $database = new Database();

              $database->update(
                "
                  update usuarios set 
                    nombre='$nombre', 
                    cedula='$cedula', 
                    direccion='$direccion', 
                    telefono='$telefono', 
                    correo='$correo', 
                    contrasena='$contrasena', 
                    rol=$rol
                  where id=$id
                "
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