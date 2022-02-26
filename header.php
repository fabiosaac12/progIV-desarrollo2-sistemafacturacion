<header id="header">
  <?php
    if (!function_exists('str_contains')) {
      function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
      }
    }

    $current = $_SERVER['REQUEST_URI'];

    if (str_contains($current, 'inicio')) {
      echo "<a class='item active' href='/inicio.php'>Inicio</a>";
    } else {
      echo "<a class='item' href='/inicio.php'>Inicio</a>";
    }

    if ($_SESSION['rol'] != 2) {
      if (str_contains($current, 'usuarios')) {
        echo "<a class='item active' href='/usuarios.php'>Usuarios</a>";
      } else {
        echo "<a class='item' href='/usuarios.php'>Usuarios</a>";
      }

      if (str_contains($current, 'jornadas')) {
        echo "<a class='item active' href='/jornadas.php'>Jornadas</a>";
      } else {
        echo "<a class='item' href='/jornadas.php'>Jornadas</a>";
      }
    }

    if (str_contains($current, 'barcos')) {
      echo "<a class='item active' href='/barcos.php'>Barcos</a>";
    } else {
      echo "<a class='item' href='/barcos.php'>Barcos</a>";
    }

    if (str_contains($current, 'facturas')) {
      echo "<a class='item active' href='/facturas.php'>Facturas</a>";
    } else {
      echo "<a class='item' href='/facturas.php'>Facturas</a>";
    }
  ?>
</header>