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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="newContent") {

      if ($_POST['nombre']!='' && $_POST['genero']!='' && $_POST['año']!='' && $_POST['tipo']!=''&& $_POST['plataforma']!='' && $_POST['director']!='' && $_POST['actor']!='') {
        $Plataforma = mysqli_real_escape_string($conn, $_POST['plataforma']);
        $sql = "SELECT ID_Plataforma as ID_Plataforma FROM Plataforma WHERE Plataforma.Nombre='$Plataforma'";
        $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result))
          $PID = $row["ID_Plataforma"];

        $Director = mysqli_real_escape_string($conn, $_POST['director']);
        $sql = "SELECT ID_Director as ID_Director FROM Director WHERE Director.Nombre='$Director'";
        $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result))
          $DID = $row["ID_Director"];

        $Actor = mysqli_real_escape_string($conn, $_POST['actor']);
        $sql = "SELECT ID_Actor as ID_Actor FROM Actor WHERE Actor.Nombre='$Actor'";
        $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result))
          $AID = $row["ID_Actor"];
        
        $sql = "SELECT MAX(ID_Contenido) as ID_Contenido FROM Contenido";
        $result = mysqli_query($conn, $sql);
        if($row = mysqli_fetch_assoc($result))
          $maxID=$row["ID_Contenido"]+1;
   
        $sql = "INSERT INTO Actor_Contenido (ID_Actor, ID_Contenido)
        VALUES(".$AID.", ".$maxID.")";
        $result = mysqli_query($conn, $sql);

        $sql = "INSERT INTO Director_Contenido (ID_Director, ID_Contenido)
        VALUES(".$DID.", ".$maxID.")";
        $result = mysqli_query($conn, $sql);

        $sql = "INSERT INTO Plataforma_Contenido (ID_Plataforma, ID_Contenido)
        VALUES(".$PID.", ".$maxID.")";
        $result = mysqli_query($conn, $sql);
        
        $Nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
        $Genero = mysqli_real_escape_string($conn, $_POST['genero']);
        $Tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
        $sql = "INSERT INTO Contenido (ID_Contenido, Nombre, Genero, Año, Tipo)
        VALUES(".$maxID.",'$Nombre','$Genero',".$_POST['año'].",'$Tipo')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style=\"color:green\">New record was created</p>";
        } else {
            echo "<p style=\"color:red\">Ha ocurrido un problema, intente de nuevo</p>";
        }
        

      } else {
        echo "<p style=\"color:red\">Necesitas llenar todos los campos</p>";
      }
    } 

    if (ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="deleteContent") {

      if ($_REQUEST['ID_Contenido']>0) {
        $sql = "DELETE FROM Actor_Contenido WHERE ID_Contenido=".$_REQUEST['ID_Contenido'];
        $result = mysqli_query($conn, $sql);
        $sql = "DELETE FROM Plataforma_Contenido WHERE ID_Contenido=".$_REQUEST['ID_Contenido'];
        $result = mysqli_query($conn, $sql);
        $sql = "DELETE FROM Director_Contenido WHERE ID_Contenido=".$_REQUEST['ID_Contenido'];
        $result = mysqli_query($conn, $sql);
        $sql = "DELETE FROM Contenido WHERE ID_Contenido=".$_REQUEST['ID_Contenido'];
        $result = mysqli_query($conn, $sql);

        if (mysqli_query($conn, $sql)) {
            echo "<p style=\"color:green\">Se eliminó correctamente</p>";
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
    <h1>Agregar nuevo contenido</h1>
  </head>
  <body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      Nombre: <input type="text" name="nombre" value="<?php echo $Nombre;?>"><br><br>
      Genero: <input type="text" name="genero" value="<?php echo $Genero;?>"><br><br>
      Año: <input type="number" name="año" value="<?php echo $Año;?>"><br><br>
      Tipo: <input type="text" name="tipo" value="<?php echo $Tipo;?>"><br><br>
      Plataforma: <input type="text" name="plataforma" value="<?php echo $Plataforma;?>"><br><br>
      Director: <input type="text" name="director" value="<?php echo $Director;?>"><br><br>
      Actor: <input type="text" name="actor" value="<?php echo $Actor;?>"><br><br><br>

      <input type="text" name="action" value="newContent" style="display:none;">
      <input type="submit" value="Add Content">

    </form><br>

    <?php

      $sql = "SELECT * FROM Contenido";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {

          echo "<table>";
          echo "<tr>";
          echo "<th>ID_Contenido</th>";
          echo "<th>Nombre</th>";
          echo "<th>Genero</th>";
          echo "<th>Año</th>";
          echo "<th>Tipo</th>";
          echo "<th>&nbsp;</th>";
          echo "</tr>";

          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            
            echo "<tr>";
            echo "<td>".$row["ID_Contenido"]."</td>";
            echo "<td>".$row["Nombre"]."</td>";
            echo "<td>".$row["Genero"]."</td>";
            echo "<td>".$row["Año"]."</td>";
            echo "<td>".$row["Tipo"]."</td>";
            echo "<td><a href=\"".$_SERVER['PHP_SELF']."?action=deleteContent&ID_Contenido=".$row["ID_Contenido"]."\">Delete</a></td>";
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

