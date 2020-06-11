<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Spiderdany10#";
    $database = "FilmFinder";

    $ID_Contenido="";
    $ID_Director="";
    $ID_Actor="";
    $ID_Plataforma="";

    $Nombre="";
    $Genero="";
    $Año="";
    $Tipo="";
    $Plataforma="";
    $Director="";
    $Actor="";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="deleteUser") {

      if ($_REQUEST['ID_Cliente']>0) {
        /*
        echo "memberNo= ".$_REQUEST['memberNo']."<br>";
        */
        $sql = "DELETE FROM Cliente WHERE ID_Cliente=".$_REQUEST['ID_Cliente'];

        if (mysqli_query($conn, $sql)) {
            echo "<p style=\"color:green\">Record was deleted</p>";
        } else {
            echo "<p style=\"color:red\">Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
        }

      } else {
        echo "<p style=\"color:red\">ERROR: Waiting for numeric memberNo value</p>";
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
    <h1>Eliminar Usuario</h1>
  </head>
  <body>
    <?php

      $sql = "SELECT * FROM Cliente";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {

          echo "<table>";
          echo "<tr>";
          echo "<th>ID_Cliente</th>";
          echo "<th>Nombre</th>";
          echo "<th>Correo</th>";
          echo "<th>Sexo</th>";
          echo "<th>Contraseña</th>";
          echo "<th>&nbsp;</th>";
          echo "</tr>";

          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            
            echo "<tr>";
            echo "<td>".$row["ID_Cliente"]."</td>";
            echo "<td>".$row["Nombre"]."</td>";
            echo "<td>".$row["Correo"]."</td>";
            echo "<td>".$row["Sexo"]."</td>";
            echo "<td>".$row["Contraseña"]."</td>";
            echo "<td><a href=\"".$_SERVER['PHP_SELF']."?action=deleteUser&ID_Cliente=".$row["ID_Cliente"]."\">Delete</a></td>";
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

