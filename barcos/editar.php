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
  <title>Editar barco</title>
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

        $barco = $database->selectOne("select * from barcos where id=$id");

        $nombre = $barco['nombre'];
        $codigo = $barco['codigo'];
        $operador = $barco['operador'];
        $tripulacion = $barco['tripulacion'];
        $capacidad_kg = $barco['capacidad_kg'];
        $porcentaje_gastos_operativos = $barco['porcentaje_gastos_operativos'] * 100;
      } else {
        throw new Exception();
      }
    } catch (Exception $e) {
      header('Location: ../barcos.php');
    }
  ?>
  
  <section class="container">
    <form action="#" method="put">
      <?php
        echo "      
          <input class='input' name='id' type='hidden' value='$id'>
          <label>Nombre</lable>
          <input class='input' placeholder='Nombre' name='nombre' type='text' required maxlength=40 value='$nombre'>
          <label>Operador</lable>
          <input class='input' placeholder='Operador' name='operador' type='text' required maxlength=100 value='$operador'>
          <label>Tripulacion</lable>
          <input class='input' placeholder='Tripulacion' name='tripulacion' type='number' required max=999999 value='$tripulacion'>
          <label>Capacidad (kg)</lable>
          <input class='input' placeholder='Capacidad (kg)' name='capacidad_kg' type='number' required max=999999999 value='$capacidad_kg'>
          <label>Gastos operativos (%)</lable>
          <input class='input' placeholder='Gastos operativos (%)' name='porcentaje_gastos_operativos' type='number' required max=10 min=5 value='$porcentaje_gastos_operativos'>
        ";
      ?>

      <p class="error">
        <?php
          if (
            isset($_GET['nombre']) 
            && isset($_GET['operador'])
            && isset($_GET['tripulacion'])
            && isset($_GET['capacidad_kg'])
            && isset($_GET['porcentaje_gastos_operativos'])
          ) {
            $nombre = $_GET['nombre'];
            $operador = $_GET['operador'];
            $tripulacion = $_GET['tripulacion'];
            $capacidad_kg = $_GET['capacidad_kg'];
            $porcentaje_gastos_operativos = $_GET['porcentaje_gastos_operativos'] / 100;

            try {
              $database = new Database();

              $database->update(
                "
                  update barcos set 
                    nombre='$nombre', 
                    codigo='$codigo', 
                    operador='$operador', 
                    tripulacion='$tripulacion', 
                    capacidad_kg='$capacidad_kg',
                    porcentaje_gastos_operativos=$porcentaje_gastos_operativos
                  where id=$id
                "
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