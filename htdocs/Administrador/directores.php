<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Spiderdany10#";
    $database = "FilmFinder";

    $Nombre="";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="nuevo") {
      if ($_POST['nombre']!='') {        
        $sql = "SELECT MAX(ID_Director) as ID_Director FROM Director";
        $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result))
          $maxID = $row["ID_Director"] + 1;
        
        $Nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $sql = "INSERT INTO Director (ID_Director, Nombre)
        VALUES(".$maxID.",'$Nombre')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style=\"color:green\">Se ha agregado al director</p>";
        } else {
            echo "<p style=\"color:red\">Ocurrió un error, intente de nuevo</p>";
        }
      } else {
        echo "<p style=\"color:red\">Necesita llenar todos los campos</p>";
      }
    } 

    if (ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="borrar") {

      if ($_REQUEST['ID_Director']>0) {
        $sql = "DELETE FROM Director WHERE ID_Director=".$_REQUEST['ID_Director'];
        $result = mysqli_query($conn, $sql);

        if (mysqli_query($conn, $sql)) {
            echo "<p style=\"color:green\">Se eliminó correctamente</p>";
        } else {
            echo "<p style=\"color:red\">Ocurrió un error, intente de nuevo</p>";
        }

      } else {
        echo "<p style=\"color:red\">Ocurrió un error, intente de nuevo</p>";
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
    <h1>Agregar nuevo director</h1>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      Nombre del director: <input type="text" name="nombre" value="<?php echo $Nombre;?>"><br><br>
      <input type="text" name="action" value="nuevo" style="display:none;">
      <input type="submit" value="Añadir">    

    </form><br>

    <?php

      $sql = "SELECT * FROM Director";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {

          echo "<table>";
          echo "<tr>";
          echo "<th>ID_Director</th>";
          echo "<th>Nombre</th>";
          echo "<th>&nbsp;</th>";
          echo "</tr>";

          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            
            echo "<tr>";
            echo "<td>".$row["ID_Director"]."</td>";
            echo "<td>".$row["Nombre"]."</td>";
            echo "<td><a href=\"".$_SERVER['PHP_SELF']."?action=borrar&ID_Director=".$row["ID_Director"]."\">Borrar</a></td>";
            echo "</tr>";
          }
      } 
      echo "</table>";

      mysqli_close($conn);
    ?>
    <br><br>
    <a href="admin.php">Regresar</a>
  </body>
</html>
