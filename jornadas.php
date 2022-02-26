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
  <title>Jornadas</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/header.css">
</head>
<body>
  <?php include 'header.php'; ?> 
  
  <section>
    <a class="button" href="/jornadas/crear.php">Crear nueva jornada</a>

    <div class="tableWrapper">
      <table>
        <tr>
          <th>Fecha</th>
          <th>Hora de inicio</th>
          <th>Hora de cierre</th>
          <th>Estado del clima</th>
          <th>Precio de mercancia (kg)</th>
          <th class="center">Acciones</th>
        </tr>

        <?php
          include './helpers/database.php';

          $database = new Database();

          $result = $database->select("
            select
              jornadas.*,
              date_format(jornadas.fecha, '%d-%m-%Y') as fecha,
              estados_clima.nombre as estado_clima
            from jornadas inner join estados_clima on jornadas.estado_clima = estados_clima.id
          ");

          foreach ($result as &$jornada) {
            $id = $jornada['id'];
            $fecha = $jornada['fecha'];
            $hora_inicio = $jornada['hora_inicio'];
            $hora_cierre = $jornada['hora_cierre'];
            $estado_clima = $jornada['estado_clima'];
            $precio_mercancia_kg = $jornada['precio_mercancia_kg'];

            echo "
              <tr>
                <td>$fecha</td>
                <td>$hora_inicio</td>
                <td>$hora_cierre</td>
                <td>$estado_clima</td>
                <td>$precio_mercancia_kg $</td>
                <td class='actions'>
                  <a class='iconButton' href='jornadas/editar.php?id=$id'>
                    <img src='assets/editar.png' alt=''>
                  </a>
                  <a class='iconButton' href='jornadas/eliminar.php?id=$id'>
                    <img src='assets/eliminar.png' alt=''>
                  </a>
                </td>
              </tr>
            ";
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