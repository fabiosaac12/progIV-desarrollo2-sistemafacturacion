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
  <title>Usuarios</title>
  <link rel="stylesheet" href="styles/index.css">
  <link rel="stylesheet" href="styles/header.css">
</head>
<body>
  <?php include 'header.php'; ?> 
  
  <section>
    <a class="button" href="/usuarios/crear.php">Crear nuevo usuario</a>

    <div class="tableWrapper">
      <table>
        <tr>
          <th>Nombre</th>
          <th>Cedula</th>
          <th>Direccion</th>
          <th>Telefono</th>
          <th>Correo</th>
          <th>Rol</th>
          <th class="center">Acciones</th>
        </tr>

        <?php
          include './helpers/database.php';

          $database = new Database();

          $id = $_SESSION['id'];

          $result = $database->select("
            select
              usuarios.*, 
              roles.nombre as rol 
            from usuarios inner join roles on usuarios.rol = roles.id 
            where usuarios.rol!=0 and usuarios.id != $id
          ");

          foreach ($result as &$user) {
            $id = $user['id'];
            $nombre = $user['nombre'];
            $cedula = $user['cedula'];
            $direccion = $user['direccion'];
            $telefono = $user['telefono'];
            $correo = $user['correo'];
            $rol = $user['rol'];

            echo "
              <tr>
                <td>$nombre</td>
                <td>$cedula</td>
                <td>$direccion</td>
                <td>$telefono</td>
                <td>$correo</td>
                <td>$rol</td>
                <td class='actions'>
                  <a class='iconButton' href='usuarios/editar.php?id=$id'>
                    <img src='assets/editar.png' alt=''>
                  </a>
                  <a class='iconButton' href='usuarios/eliminar.php?id=$id'>
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