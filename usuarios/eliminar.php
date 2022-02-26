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
  <title>Eliminar usuario</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/crud/eliminar.css">
</head>
<body>
  <?php include '../header.php'; ?> 

  <?php
    try {
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $eliminar = isset($_GET['eliminar']);

        include '../helpers/database.php';
        $database = new Database();

        $user = $database->selectOne("select * from usuarios where id=$id");

        if ($user['rol'] == 0) {
          throw new Exception();
        }

        if ($user['id'] == $_SESSION['id']) {
          throw new Exception();
        }

        $nombre = $user['nombre'];

        if ($eliminar) {
          try {
            $done = $database->delete("delete from usuarios where id=$id");

            if ($done) {
              header('Location: ../usuarios.php');
            } else {
              throw new Exception();
            }
          } catch (Exception $e) {
            $error = "Debe eliminar primero las facturas de este usuario";
          }
        }
      } else {
        throw new Exception();
      }
    } catch (Exception $e) {
      header('Location: ../usuarios.php');
    }
  ?>
  
  <section class="container">
    <div class="modal">
      <p class="title">
        <?php 
          echo "¿Estas seguro de eliminar el usuario $nombre?";
        ?>
      </p>
      <form method="delete" class="actions">
        <?php 
          echo "<input type='hidden' name='id' value='$id'>";
        ?>
        <a class="button cancel" href="/usuarios.php">
          Cancelar
        </a>
        <input type="submit" name="eliminar" class="button accept" value="Eliminar" />
      </form>
      <p class="error">
        <?php
          if (isset($error)) {
            echo $error;
          }
        ?>
      </p>
    </div>
  </section>
</body>
</html>