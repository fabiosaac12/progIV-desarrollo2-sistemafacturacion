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
  <title>Inicio</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/header.css">
  <link rel="stylesheet" href="styles/inicio.css">
</head>
<body>
  <?php include 'header.php'; ?> 

  <?php
    include './helpers/database.php';

    $id = $_SESSION['id'];

    $database = new Database();

    $user = $database->selectOne("
      select
        usuarios.*, 
        roles.nombre as rol 
      from usuarios inner join roles on usuarios.rol = roles.id 
      where usuarios.id = $id;
    ");

    $nombre = $user['nombre'];
    $cedula = $user['cedula'];
    $direccion = $user['direccion'];
    $telefono = $user['telefono'];
    $correo = $user['correo'];
    $contrasena = $user['contrasena'];
    $rol = $user['rol'];

    try {
      $jornada = $database->selectOne("
        select 
          jornadas.*,
          date_format(jornadas.fecha, '%d-%m-%Y') as fecha,
          estados_clima.nombre as estado_clima
        from jornadas 
          inner join estados_clima on jornadas.estado_clima = estados_clima.id
        where date(fecha) = curdate();
      ");

      $fecha = $jornada['fecha'];
      $hora_inicio = $jornada['hora_inicio'];
      $hora_cierre = $jornada['hora_cierre'];
      $estado_clima = $jornada['estado_clima'];
      $precio_mercancia_kg = $jornada['precio_mercancia_kg'];

      $jornada_activa = true;
    } catch (Exception $e) {}
  ?>

  <section>
    <div class="card">
      <h3 class="center title">Perfil</h3>

      <div class="row">
        <span class="label">Nombre: </span>
        <?php echo $nombre ?>
      </div>
      <div class="row">
        <span class="label">Cedula: </span>
        <?php echo $cedula ?>
      </div>
      <div class="row">
        <span class="label">Direccion: </span>
        <?php echo $direccion ?>
      </div>
      <div class="row">
        <span class="label">Telefono: </span>
        <?php echo $telefono ?>
      </div>
      <div class="row">
        <span class="label">Correo: </span>
        <?php echo $correo ?>
      </div>
      <div class="row">
        <span class="label">Rol: </span>
        <?php echo $rol ?>
      </div>

      <div class="row buttonRow">
        <?php
          if ($_SESSION['rol'] != 0) {
            echo "
              <a class='button' href='usuarios/editar.php?id=$id'>
                Modificar perfil
              </a>
            ";
          }
        ?>
      </div>

      <div class="row buttonRow">
        <a class='button' href='usuarios/cambiar_contrasena.php'>
          Cambiar contraseña
        </a>
      </div>

      <div class="row buttonRow">
        <a class='button danger' href='login.php?cerrar_sesion=1'>
          Cerrar sesion
        </a>
      </div>
    </div>

    <?php
      if (isset($jornada_activa)) {
        echo "
          <div class='card'>
            <h3 class='center title'>Jornada actual $fecha</h3>

            <div class='row'>
              <span class='label'>Hora de inicio: </span>
              $hora_inicio
            </div>
            <div class='row'>
              <span class='label'>Hora de cierre: </span>
              $hora_cierre
            </div>
            <div class='row'>
              <span class='label'>Estado del clima: </span>
              $estado_clima
            </div>
            <div class='row'>
              <span class='label'>Precio de mercancia: </span>
              $precio_mercancia_kg $ / kg
            </div>
          </div>
        ";
      } else {
        if ($_SESSION['rol'] != 2) {
          echo "
            <div class='card'>
              <h3 class='title'>No hay una jornada activa</h3>
              <div class='row buttonRow noJornada'>
                <a class='button fullWidth' href='jornadas/crear.php'>
                  Crear una jornada
                </a>
              </div>
            </div>
          ";
        }
      }
    ?>
  </section>
</body>
</html>