<?php
  class Auth {
    public static function verifyRol() {
      if (isset($_SESSION['rol'])) {
        switch ($_SESSION['rol']) {
          case 0;
              header('Location: ../inicio.php');
            break;
          case 1:
              header('Location: ../inicio.php');
            break;
          case 2;
              header('Location: ../inicio.php');
            break;
        }
      } else {
        if (basename($_SERVER['PHP_SELF']) != 'login.php') {
          header('Location: ../login.php');
        }
      }
    }
  }
?>