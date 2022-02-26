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
  <title>Facturas</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/header.css">
</head>
<body>
  <?php include 'header.php'; ?> 
  
  <section>
    <?php 
      include './helpers/database.php';

      $database = new Database();

      try {
        $jornada = $database->selectOne("
          select jornadas.* from jornadas where date(fecha) = curdate();
        ");

        $jornada_activa = true;
      } catch (Exception $e) {
        $jornada_activa = false;
      }

      if ($jornada_activa) {
        echo "
          <a class='button' href='/facturas/crear.php'>Crear nueva factura</a>
        ";
      } else {
        echo "<p class='error'>Por los momentos no hay una jornada activa</p>";
      }
    ?>

    <div class="tableWrapper">
      <table>
        <tr>
          <th>Codigo</th>
          <th>Fecha</th>
          <th>Barco</th>
          <th class="center">Acciones</th>
        </tr>

        <?php
          $query = "
            select 
              facturas.id,
              facturas.codigo,
              jornadas.fecha,
              barcos.nombre as barco
            from facturas 
              inner join barcos on facturas.id_barco = barcos.id 
              inner join jornadas on facturas.id_jornada = jornadas.id 
          ";

          if ($rol == 2) {
            $userId = $_SESSION['id'];
            $query .= " where facturas.id_usuario = $userId";
          }

          $result = $database->select($query);

          foreach ($result as &$factura) {
            $id = $factura['id'];
            $codigo = $factura['codigo'];
            $fecha = $factura['fecha'];
            $barco = $factura['barco'];

            echo "
              <tr>
                <td>$codigo</td>
                <td>$fecha</td>
                <td>$barco</td>
                <td class='actions'>
                  <a class='iconButton' href='facturas/ver.php?id=$id'>
                    <img src='assets/view.png' alt=''>
                  </a>
                  <a class='iconButton' href='facturas/editar.php?id=$id'>
                    <img src='assets/editar.png' alt=''>
                  </a>
                  <a class='iconButton' href='facturas/eliminar.php?id=$id'>
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