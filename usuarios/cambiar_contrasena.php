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
  <title>Cambiar contraseña</title>
  <link rel="stylesheet" href="../styles/index.css">
  <link rel="stylesheet" href="../styles/header.css">
  <link rel="stylesheet" href="../styles/crud/editar.css">
</head>
<body>
  <?php include '../header.php'; ?> 
  
  <section class="container">
    <form action="#" method="put">
      <label>Nueva contraseña</label>
      <input class='input' placeholder='Nueva contraseña' name='contrasena' type='password' required>

      <p class="error">
        <?php
          if (
            isset($_GET['contrasena'])
          ) {
            $id = $_SESSION['id'];
            $contrasena = password_hash($_GET['contrasena'], PASSWORD_DEFAULT);

            try {
              include '../helpers/database.php';

              $database = new Database();

              $database->update(
                "
                  update usuarios set
                    contrasena='$contrasena'
                  where id=$id
                "
              );

              header('Location: ../inicio.php');
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