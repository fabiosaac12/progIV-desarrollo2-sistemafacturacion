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
  <title>Crear jornada</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/crud/crear.css">
</head>
<body>
  <?php include '../header.php'; ?> 
  
  <section class="container">
    <form action="#" method="post">
      <label>Fecha</lable>
      <input class="input" placeholder="Fecha" name="fecha" type="date" required>
      <label>Hora de inicio</lable>
      <input class="input" placeholder="Hora de inicio" name="hora_inicio" type="time" required>
      <label>Hora de cierre</lable>
      <input class="input" placeholder="Hora de cierre" name="hora_cierre" type="time" required>
      <label>Estado del clima</lable>
      <select class="input" placeholder="Estado del clima" name="estado_clima" required>
        <option value=0 selected="selected">Soleado</option>
        <option value=1>Lluvioso</option>
        <option value=2>Nublado</option>
        <option value=3>Ventoso</option>
      </select>
      <label>Precio de mercancia por kg ($)</lable>
      <input class="input" placeholder="Precio de mercancia por kg ($)" name="precio_mercancia_kg" type="number" max=99999 required>

      <p class="error">
        <?php
          include '../helpers/database.php';

          if (
            isset($_POST['fecha']) 
            && isset($_POST['hora_inicio'])
            && isset($_POST['hora_cierre'])
            && isset($_POST['estado_clima'])
            && isset($_POST['precio_mercancia_kg'])
          ) {
            $fecha = $_POST['fecha'];
            $hora_inicio = $_POST['hora_inicio'];
            $hora_cierre = $_POST['hora_cierre'];
            $estado_clima = $_POST['estado_clima'];
            $precio_mercancia_kg = $_POST['precio_mercancia_kg'];
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $rol = $_POST['rol'];

            try {
              $database = new Database();

              $database->insert(
                "
                  insert into jornadas 
                    values (null, '$fecha', '$hora_inicio', '$hora_cierre', '$estado_clima', '$precio_mercancia_kg')
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