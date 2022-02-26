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
  <title>Editar factura</title>
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

        $factura = $database->selectOne("
          select 
            facturas.*,
            date_format(jornadas.fecha, '%d-%m-%Y') as fecha_jornada
          from facturas 
            inner join jornadas on facturas.id_jornada = jornadas.id
          where facturas.id=$id
        ");

        $codigo = $factura['codigo'];
        $id_jornada = $factura['id_jornada'];
        $fecha_jornada = $factura['fecha_jornada'];
        $id_usuario = $factura['id_usuario'];
        $id_barco = $factura['id_barco'];
        $cantidad_mercancia_kg = $factura['cantidad_mercancia_kg'];
        $hora_generacion = $factura['hora_generacion'];

        if (($_SESSION['id'] != $id_usuario) && ($_SESSION['rol'] != 0)) {
          throw new Exception();
        }
      } else {
        throw new Exception();
      }
    } catch (Exception $e) {
      header('Location: ../facturas.php');
    }
  ?>
  
  <section class="container">
    <form action="#" method="put">
      <?php
        echo "<input class='input' name='id' type='hidden' value='$id'>";
      ?>
      
      <label>Jornada</lable>
      <select class="input" placeholder="Jornada" name="id_jornada" disabled>
        <?php
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

            if ($id_barco == $id) {
              echo "<option selected='selected' value='$id'>$nombre</option>";
            } else {
              echo "<option value='$id'>$nombre</option>";
            }
          }
        ?>
      </select>

      <label>Cantidad de mercancia (kg)</lable>
      <?php
        echo "      
          <input class='input' placeholder='Cantidad de mercancia (kg)' name='cantidad_mercancia_kg' type='number' required max=999999999 value=$cantidad_mercancia_kg>
        ";
      ?>

      <p class="error">
        <?php
          if (
            isset($_GET['id'])
            && isset($_GET['id_barco'])
            && isset($_GET['cantidad_mercancia_kg'])
          ) {
            $id = $_GET['id'];
            $id_barco = $_GET['id_barco'];
            $cantidad_mercancia_kg = $_GET['cantidad_mercancia_kg'];

            try {
              $database = new Database();

              $database->update(
                "
                  update facturas set 
                    codigo='$codigo', 
                    id_jornada='$id_jornada', 
                    id_usuario='$id_usuario', 
                    id_barco='$id_barco', 
                    cantidad_mercancia_kg='$cantidad_mercancia_kg', 
                    hora_generacion='$hora_generacion'
                  where id=$id
                "
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