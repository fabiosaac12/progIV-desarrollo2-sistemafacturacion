<?php
  session_start();

  try {
    if (isset($_SESSION['rol'])) {
      $rol = $_SESSION['rol'];
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
  <title>Barcos</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/header.css">
</head>
<body>
  <?php include 'header.php'; ?> 
  
  <section>
    <?php
      if ($rol != 2) {
        echo "<a class='button' href='/barcos/crear.php'>Crear nuevo barco</a>";
      }
    ?>

    <div class="tableWrapper">
      <table>
        <tr>
          <th>Nombre</th>
          <th>Codigo</th>
          <th>Operador</th>
          <th>Tripulacion</th>
          <th>Capacidad</th>
          <th>Gastos operativos</th>
          <?php
            if ($rol != 2) {
              echo "<th class='center'>Acciones</th>";
            }
          ?>
        </tr>

        <?php
          include './helpers/database.php';

          $database = new Database();

          $result = $database->select("select * from barcos");

          foreach ($result as &$barco) {
            $id = $barco['id'];
            $nombre = $barco['nombre'];
            $codigo = $barco['codigo'];
            $operador = $barco['operador'];
            $tripulacion = $barco['tripulacion'];
            $capacidad_kg = $barco['capacidad_kg'];
            $porcentaje_gastos_operativos = $barco['porcentaje_gastos_operativos'] * 100;

            echo "<tr>";
            echo "
                <td>$nombre</td>
                <td>$codigo</td>
                <td>$operador</td>
                <td>$tripulacion</td>
                <td>$capacidad_kg kg</td>
                <td>$porcentaje_gastos_operativos %</td>
            ";
            if ($rol !=2) {
              echo "
                <td class='actions'>
                  <a class='iconButton' href='barcos/editar.php?id=$id'>
                    <img src='assets/editar.png' alt=''>
                  </a>
                  <a class='iconButton' href='barcos/eliminar.php?id=$id'>
                    <img src='assets/eliminar.png' alt=''>
                  </a>
                </td>
              ";
            }
            echo "</tr>";
          }

          if (count($result) == 0) {
            echo "
              <tr>
                <td class='noData' colspan=9>Por ahora no se han creado facturas</td>
              </tr>
            ";
          }
        ?>
      </table>
    </div>
  </section>
</body>
</html>