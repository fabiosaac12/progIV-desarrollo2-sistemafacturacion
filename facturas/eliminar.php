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
  <title>Eliminar jornada</title>
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

        $factura = $database->selectOne("select * from facturas where id=$id");
        $id_usuario = $factura['id_usuario'];
        $codigo = $factura['codigo'];

        if (($_SESSION['id'] != $id_usuario) && ($_SESSION['rol'] != 0)) {
          throw new Exception();
        }

        if ($eliminar) {
          $done = $database->delete("delete from facturas where id=$id");
          if ($done) {
            header('Location: ../facturas.php');
          } else {
            $error = "Ha ocurrido un error al intentar eliminar la factura";
          }
        }
      } else {
        throw new Exception();
      }
    } catch (Exception $e) {
      header('Location: ../facturas.php');
    }
  ?>
  
  <section class="container">
    <div class="modal">
      <p class="title">
        <?php 
          echo "¿Estas seguro de eliminar la factura con el codigo $codigo?";
        ?>
      </p>
      <form method="delete" class="actions">
        <?php 
          echo "<input type='hidden' name='id' value='$id'>";
        ?>
        <a class="button cancel" href="/facturas.php">
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