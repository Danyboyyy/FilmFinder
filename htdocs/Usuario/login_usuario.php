<?php
    session_start();

    $servername = "127.0.0.1";
    $username = "root";
    $password = "Spiderdany10#";
    $database = "FilmFinder";

    $usuario = "";
    $contraseña = "";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="login") {

      if ($_POST['usuario']!='' && $_POST['contraseña']!='') {
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $contraseña = mysqli_real_escape_string($conn, $_POST['contraseña']); 

        $sql = "SELECT ID_Cliente FROM Cliente WHERE Nombre = '$usuario' AND Contraseña = '$contraseña'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);

        if($count == 1) {
            $_SESSION['username'] = $usuario;
            echo "<p style=\"color:green\">Logged in</p>";
            header("Location:usuario.php");
        } else {
            echo "<p style=\"color:red\">Nombre de usuario o contraseña incorrectos</p>";
        }
        
      } else {
        echo "<p style=\"color:red\">Necesitas llenar todos los campos</p>";
      }
    }   

?> 

<html>
  <head>
    <h1>Inicio de sesión</h1>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      Nombre de usuario: <input type="text" name="usuario" value="<?php echo $usuario;?>"><br><br>
      Contraseña: <input type="text" name="contraseña" value="<?php echo $contraseña;?>"><br><br>  

      <input type="text" name="action" value="login" style="display:none;">
      <input type="submit" value="Inciar Sesión">
    </form>
    <br>

    <a href="/../index.php">Regresar</a>
  </body>
</html>
