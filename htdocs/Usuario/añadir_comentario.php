<?php
    session_start();

    $servername = "127.0.0.1";
    $username = "root";
    $password = "Spiderdany10#";
    $database = "FilmFinder";

    $usuario = "";
    $comentario = "";
    $contenido = "";

    $idU;

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="add") {
      if ($_POST['comentario']!='' && $_POST['contenido']!='') {
        $usuario = $_SESSION['username'];
        $contenido = mysqli_real_escape_string($conn, $_POST['contenido']); 
        $comentario = mysqli_real_escape_string($conn, $_POST['comentario']); 

        $sql = "SELECT ID_Cliente FROM Cliente WHERE Nombre = '$usuario'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);

        if($count > 0) {
          $idU = $row["ID_Cliente"]; 
    
          $sql = "SELECT B.ID_Contenido FROM Busquedas B, Contenido C WHERE C.Nombre='$contenido' AND B.ID_Contenido=C.ID_Contenido AND ID_Cliente='$idU'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_array($result);
          $count = mysqli_num_rows($result);

          if ($count < 1) {
            $sql = "SELECT ID_Contenido FROM Contenido C WHERE C.Nombre='$contenido'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $idC = $row["ID_Contenido"];

            $sql = "INSERT INTO Busquedas (ID_Cliente, ID_Contenido, Favoritos, Comentarios)
            VALUES (".$idU.", ".$idC.", 0, '$comentario')";
            if (mysqli_query($conn, $sql)) {
              echo "<p style=\"color:green\">Comentario enviado</p>";
            } else {
                echo "<p style=\"color:red\">Ocurrió un error, inténtelo de nuevo</p>";
            }
          } else {
            $sql = "UPDATE Busquedas 
                SET Comentarios='$comentario'
                WHERE ID_Contenido=".$row["ID_Contenido"]." AND ID_Cliente='$idU'";
            if (mysqli_query($conn, $sql)) {
              echo "<p style=\"color:green\">Comentario enviado</p>";
            } else {
              echo "<p style=\"color:red\">Ocurrió un error, inténtelo de nuevo</p>";
            }
          }
        } else {
            echo "<p style=\"color:red\">Nombre de usuario no existente</p>";
        }
      }
    }   
?> 

<html>
  <head>
    <h1>Añadir Comentario</h1>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      Contenido: <input type="text" name="contenido" value="<?php echo $contenido;?>"><br><br>
      Comentario: <input type="text" name="comentario" value="<?php echo $comentario;?>"><br><br>
      <input type="text" name="action" value="add" style="display:none;">
      <input type="submit" value="Comentar">
    </form>
    <br>
    
    <br><br><a href="usuario.php">Regresar</a>
  </body>
</html>