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
  <title>Ver factura</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/facturas/ver.css">
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
            facturas.id_usuario,
            facturas.codigo,
            date_format(jornadas.fecha, '%d-%m-%Y') as fecha,
            jornadas.precio_mercancia_kg,
            facturas.hora_generacion,
            facturas.cantidad_mercancia_kg,
            usuarios.nombre as nombre_cajero,
            barcos.nombre as nombre_barco,
            barcos.operador as operador_barco,
            barcos.porcentaje_gastos_operativos
          from facturas 
            inner join jornadas on facturas.id_jornada = jornadas.id
            inner join usuarios on facturas.id_usuario = usuarios.id
            inner join barcos on facturas.id_barco = barcos.id
          where facturas.id=$id;
        ");

        $id_usuario = $factura['id_usuario'];
        $codigo = $factura['codigo'];
        $fecha = $factura['fecha'];
        $hora_generacion = $factura['hora_generacion'];
        $cantidad_mercancia_kg = $factura['cantidad_mercancia_kg'];
        $nombre_cajero = $factura['nombre_cajero'];
        $nombre_barco = $factura['nombre_barco'];
        $operador_barco = $factura['operador_barco'];
        $porcentaje_gastos_operativos = $factura['porcentaje_gastos_operativos'] * 100;
        $precio_mercancia_kg = $factura['precio_mercancia_kg'];

        $ganancia_bruta = $cantidad_mercancia_kg *  $precio_mercancia_kg;
        $gastos_operativos = ($porcentaje_gastos_operativos / 100) * $ganancia_bruta;
        $ganancia_neta = $ganancia_bruta - $gastos_operativos;

        if (($_SESSION['id'] != $id_usuario) && ($_SESSION['rol'] == 2)) {
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
    <div class="factura">
      <h3 class="title">Alimentos Marinos de Nueva Esparta C.A.</h3>
      <h4 class="subtitle">Comprobante de Transacción</h4>

      <div class="detailsContainer">
        <div class="row">
          <div>
            <span class="label">Fecha: </span>
            <?php echo $fecha ?>
          </div>
          <div>
            <span class="label">Hora: </span>
            <?php echo $hora_generacion ?>
          </div>
        </div>

        <div class="row">
          <div class="nombreCajero">
            <span class="label">Cajero: </span>
            <?php echo $nombre_cajero ?>
          </div>
        </div>

        <div class="row">
          <div>
            <span class="label">Barco: </span>
            <?php echo $nombre_barco ?>
          </div>
        </div>

        <div class="row">
          <div class="operadorBarco">
            <span class="label">Operador: </span>
            <?php echo $operador_barco ?>
          </div>
        </div>

        <div class="row">
          <div>
            <span class="label">Mercancia recibida: </span>
            <?php echo $cantidad_mercancia_kg, " kg" ?>
          </div>
          <div>
            <span class="label">+</span>
            <?php echo $ganancia_bruta, " $" ?>
          </div>
        </div>

        <div class="row">
          <div>
            <span class="label">Gastos operativos: </span>
            <?php echo $porcentaje_gastos_operativos, " %" ?>
          </div>
          <div>
            <span class="label">-</span>
            <?php echo $gastos_operativos, " $" ?>
          </div>
        </div>

        <div class="row">
          <div></div>
          <div class="total">
            <span class="label">Total a pagar:</span>
            <?php echo $ganancia_neta, " $" ?>
          </div>
        </div>
      </div>
      <div class="rightDetails"></div>
    </div>
  </section>
</body>
</html>