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
  <title>Crear barco</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/crud/crear.css">
</head>
<body>
  <?php include '../header.php'; ?> 
  
  <section class="container">
    <form action="#" method="post">
      <label>Nombre</lable>
      <input class="input" placeholder="Nombre" name="nombre" type="text" required maxlength=40>
      <label>Operador</lable>
      <input class="input" placeholder="Operador" name="operador" type="text" required maxlength=100>
      <label>Tripulacion</lable>
      <input class="input" placeholder="Tripulacion" name="tripulacion" type="number" required max=999999>
      <label>Capacidad (kg)</lable>
      <input class="input" placeholder="Capacidad (kg)" name="capacidad_kg" type="number" required max=999999999>
      <label>Porcentaje de gastos operativos (%)</lable>
      <input class="input" placeholder="Porcentaje de gastos operativos (%)" name="porcentaje_gastos_operativos" type="number" required max=10 min=5>

      <p class="error">
        <?php
          include '../helpers/database.php';

          if (
            isset($_POST['nombre']) 
            && isset($_POST['operador'])
            && isset($_POST['tripulacion'])
            && isset($_POST['capacidad_kg'])
            && isset($_POST['porcentaje_gastos_operativos'])
          ) {
            $nombre = $_POST['nombre'];
            $operador = $_POST['operador'];
            $tripulacion = $_POST['tripulacion'];
            $capacidad_kg = $_POST['capacidad_kg'];
            $porcentaje_gastos_operativos = $_POST['porcentaje_gastos_operativos'] / 100;
            $codigo = uniqid();

            try {
              $database = new Database();

              $database->insert(
                "insert into barcos values (null, '$nombre', '$codigo', '$operador', '$tripulacion', '$capacidad_kg', $porcentaje_gastos_operativos)"
              );
              
              header('Location: ../barcos.php');
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