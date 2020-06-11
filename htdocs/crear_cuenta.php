<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Spiderdany10#";
    $database = "FilmFinder";

    $Nombre="";
    $Sexo="";
    $Correo="";
    $Contraseña="";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="nuevo") {
      if ($_POST['nombre']!='') {        
        $sql = "SELECT MAX(ID_Cliente) as ID_Cliente FROM Cliente";
        $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result))
          $maxID = $row["ID_Cliente"] + 1;
        
        $Nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $Sexo = mysqli_real_escape_string($conn, $_POST['sexo']);
        $Correo = mysqli_real_escape_string($conn, $_POST['correo']);
        $Contraseña = mysqli_real_escape_string($conn, $_POST['contraseña']);
        $sql = "INSERT INTO Cliente (ID_Cliente, Nombre, Sexo, Correo, Contraseña)
        VALUES(".$maxID.",'$Nombre', '$Sexo', '$Correo', '$Contraseña')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style=\"color:green\">Creado correctamente</p>";
            header("Location:Usuario/login_usuario.php");
        } else {
            echo "<p style=\"color:red\">Ocurrió un error, intente de nuevo</p>";
        }
      } else {
        echo "<p style=\"color:red\">Necesita llenar todos los campos</p>";
      }
    } 
?> 

<html>
  <style type="text/css">
    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid black;
      text-align: left;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
  </style>
  <head>
    <h1>Crear cuenta</h1>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      Nombre de usuario: <input type="text" name="nombre" value="<?php echo $Nombre;?>"><br><br>
      Sexo: <input type="text" name="sexo" value="<?php echo $Sexo;?>"><br><br>
      Correo: <input type="text" name="correo" value="<?php echo $Correo;?>"><br><br>
      Contraseña: <input type="text" name="contraseña" value="<?php echo $Contraseña;?>"><br><br>
      <input type="text" name="action" value="nuevo" style="display:none;">
      <input type="submit" value="Crear">    

    </form><br>

    <?php
      mysqli_close($conn);
    ?>
    <br>
    <a href="index.php">Regresar</a>
  </body>
</html>
