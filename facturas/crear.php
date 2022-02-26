<?php
  session_start();
  date_default_timezone_set("America/Caracas");

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
  
  include '../helpers/database.php';

  $database = new Database();

  try {
    $jornada = $database->selectOne("
      select jornadas.* from jornadas where date(fecha) = curdate();
    ");
  } catch (Exception $e) {
    header('Location: ../facturas.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear factura</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/crud/crear.css">
</head>
<body>
  <?php include '../header.php'; ?> 
  
  <section class="container">
    <form action="#" method="post">
      <label>Jornada</lable>
      <select class="input" placeholder="Jornada" name="id_jornada" disabled>
        <?php
          $id_jornada = $jornada['id'];
          $fecha_jornada = $jornada['fecha'];

          echo "
            <option selected='selected' value='$id_jornada'>
              $fecha_jornada ($id_jornada)
            </option>
          ";
        ?>
      </select>

      <label>Barco</lable>
      <select class="input" placeholder="Barco" name="id_barco" required>
        <?php
          $barcos = $database->select("select id, nombre from barcos");

          foreach ($barcos as &$barco) {
            $id = $barco['id'];
            $nombre = $barco['nombre'];

            echo "<option value='$id'>$nombre</option>";
          }
        ?>
      </select>

      <label>Cantidad de mercancia (kg)</lable>
      <input class="input" placeholder="Cantidad de mercancia (kg)" name="cantidad_mercancia_kg" type="number" required max=999999999>

      <p class="error">
        <?php
          if (
            isset($_POST['id_barco'])
            && isset($_POST['cantidad_mercancia_kg'])
          ) {
            $id_barco = $_POST['id_barco'];
            $cantidad_mercancia_kg = $_POST['cantidad_mercancia_kg'];
            $id_usuario = $_SESSION['id'];
            $codigo = uniqid();
            $hora_generacion = date('H:i');

            try {
              $database->insert(
                "insert into facturas values (
                  null, '$codigo', '$id_jornada', '$id_usuario', '$id_barco', '$cantidad_mercancia_kg', '$hora_generacion'
                )"
              );
              
              header('Location: ../facturas.php');
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