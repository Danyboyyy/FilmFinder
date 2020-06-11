<?php
    session_start();

    $servername = "127.0.0.1";
    $username = "root";
    $password = "Spiderdany10#";
    $database = "FilmFinder";

    $usuario = "";
    $sugerencia = "";

    $idU;

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="add") {

      if ($_POST['sugerencia']!='') {
        $usuario = $_SESSION['username'];
        $sugerencia = mysqli_real_escape_string($conn, $_POST['sugerencia']); 

        $sql = "SELECT ID_Cliente FROM Cliente WHERE Nombre = '$usuario'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);

        if($count > 0) {
          $idU = $row["ID_Cliente"]; 
    
          $sql = "INSERT INTO Sugerencia (ID_Cliente, Contenido)
          VALUES (".$idU.", '$sugerencia')";
          if (mysqli_query($conn, $sql)) {
            echo "<p style=\"color:green\">Sugerencia enviada</p>";
          } else {
              echo "<p style=\"color:red\">Hubo un error, inténtelo de nuevo</p>";
          }

        } else {
            echo "<p style=\"color:red\">Nombre de usuario no existente</p>";
        }
      }
    }   

?> 

<html>
  <head>
    <h1>Sugerencias</h1>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      Escriba aquí su sugerencia: <input type="text" name="sugerencia" value="<?php echo $sugerencia;?>"><br><br>
      <input type="text" name="action" value="add" style="display:none;">
      <input type="submit" value="Enviar Sugerencia">
    </form>
    <br>
    
    <br><br><a href="usuario.php">Regresar</a>
  </body>
</html>