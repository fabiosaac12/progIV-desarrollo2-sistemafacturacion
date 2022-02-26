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
    include './helpers/auth.php';

    Auth::verifyRol();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar jornada</title>
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

        $jornada = $database->selectOne("select * from jornadas where id=$id");

        $fecha = $jornada['fecha'];
        $hora_inicio = $jornada['hora_inicio'];
        $hora_cierre = $jornada['hora_cierre'];
        $estado_clima = $jornada['estado_clima'];
        $precio_mercancia_kg = $jornada['precio_mercancia_kg'];
      } else {
        throw new Exception();
      }
    } catch (Exception $e) {
      header('Location: ../jornadas.php');
    }
  ?>
  
  <section class="container">
    <form action="#" method="put">
      <?php
        echo "      
          <input class='input' name='id' type='hidden' value='$id'>
          <label>Fecha</lable>
          <input class='input' placeholder='Fecha' name='fecha' type='date' required value='$fecha'>
          <label>Hora de inicio</lable>
          <input class='input' placeholder='Hora de inicio' name='hora_inicio' type='time' required value='$hora_inicio'>
          <label>Hora de cierre</lable>
          <input class='input' placeholder='Hora de cierre' name='hora_cierre' type='time' required value='$hora_cierre'>
          <label>Precio de mercancia por kg ($)</lable>
          <input class='input' placeholder='Precio de mercancia por kg ($)' name='precio_mercancia_kg' type='number' required value='$precio_mercancia_kg' max=99999>
        ";
      ?>
      <label>Estado del clima</lable>
      <select class='input' placeholder='Estado del clima' name='estado_clima' required>
        <?php 
          if ($estado_clima == 0) {
            echo "
              <option value=0 selected='selected'>Soleado</option>
              <option value=1>Lluvioso</option>
              <option value=2>Nublado</option>
              <option value=3>Ventoso</option>
            ";
          } else if ($estado_clima == 1) {
            echo "
              <option value=0>Soleado</option>
              <option value=1 selected='selected'>Lluvioso</option>
              <option value=2>Nublado</option>
              <option value=3>Ventoso</option>
            ";
          } else if ($estado_clima == 2) {
            echo "
              <option value=0>Soleado</option>
              <option value=1>Lluvioso</option>
              <option value=2 selected='selected'>Nublado</option>
              <option value=3>Ventoso</option>
            ";
          } else if ($estado_clima == 3) {
            echo "
              <option value=0>Soleado</option>
              <option value=1>Lluvioso</option>
              <option value=2>Nublado</option>
              <option value=3 selected='selected'>Ventoso</option>
            ";
          }
        ?>
      </select>

      <p class="error">
        <?php
          if (
            isset($_GET['fecha']) 
            && isset($_GET['hora_inicio'])
            && isset($_GET['hora_cierre'])
            && isset($_GET['estado_clima'])
            && isset($_GET['precio_mercancia_kg'])
          ) {
            $fecha = $_GET['fecha'];
            $hora_inicio = $_GET['hora_inicio'];
            $hora_cierre = $_GET['hora_cierre'];
            $estado_clima = $_GET['estado_clima'];
            $precio_mercancia_kg = $_GET['precio_mercancia_kg'];

            try {
              $database = new Database();

              $database->update(
                "
                  update jornadas set 
                    fecha='$fecha', 
                    hora_inicio='$hora_inicio', 
                    hora_cierre='$hora_cierre', 
                    estado_clima='$estado_clima', 
                    precio_mercancia_kg='$precio_mercancia_kg'
                  where id=$id
                "
              );

              header('Location: ../jornadas.php');
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