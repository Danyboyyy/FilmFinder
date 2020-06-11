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
    <h1>Búsqueda por directores</h1>
  </head>
  <body>
    <?php
      session_start();
      $usuario = $_SESSION['username'];

      $servername = "127.0.0.1";
      $username = "root";
      $password = "Spiderdany10#";
      $database = "FilmFinder";

      $genero="";
      $result="";

      // Create connection
      $conn = mysqli_connect($servername, $username, $password, $database);
      // Check connection
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST" && ISSET($_REQUEST["action"]) && $_REQUEST["action"]=="search"){
        if ($_POST['genero']!=''){
          $genero = mysqli_real_escape_string($conn, $_POST['genero']);
          $sql = "SELECT C.Nombre, P.Link FROM Contenido C, Plataforma P, Plataforma_Contenido PC
          WHERE C.Genero='$genero' AND C.ID_Contenido = PC.ID_Contenido AND PC.ID_Plataforma = P.ID_Plataforma";
          $result = mysqli_query($conn, $sql);
        }
      }
    ?>
    
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> 
      Género: <input type="text" name="genero" value="<?php echo $genero;?>"><br>
      <input type="text" name="action" value="search" style="display:none;">
      <input type="submit" value="Buscar">
    </form><br>

    <?php
      if (!empty($result) && mysqli_num_rows($result) > 0) {
      
        echo "<table>";
        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Enlace</th>";
        echo "</tr>";

        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            
          echo "<tr>";
          echo "<td><a href='?link=".$row["Nombre"]."'>".$row["Nombre"]."</a></td>";
          echo "<td><a href='https://".$row["Link"]."' target='_blank'>".$row["Link"]."</a></td>";
          echo "</tr>";
        }
      }
      echo "</table>";

      if (ISSET($_GET["link"])) {
        $name = $_GET["link"];
        echo "<h1>".$name."</h1><br>";

        $sql = "SELECT A.Nombre FROM Actor A, Contenido C, Actor_Contenido AC
        WHERE C.Nombre='$name' AND AC.ID_Contenido=C.ID_Contenido AND A.ID_Actor=AC.ID_Actor";
        $result = mysqli_query($conn, $sql);
        if (!empty($result) && mysqli_num_rows($result) > 0) {
          echo "<table>";
          echo "<tr>";
          echo "<th>Actor</th>";
          echo "</tr>";
  
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row["Nombre"]."</td>";
            echo "</tr>";
          }
        } else {
          echo "<p style=\"color:red\">No hay resultados disponibles</p>";
        }
        echo "</table><br><br>";

        $sql = "SELECT D.Nombre FROM Director D, Contenido C, Director_Contenido DC
        WHERE C.Nombre='$name' AND DC.ID_Contenido=C.ID_Contenido AND D.ID_Director=DC.ID_Director";
        $result = mysqli_query($conn, $sql);
        if (!empty($result) && mysqli_num_rows($result) > 0) {
          echo "<table>";
          echo "<tr>";
          echo "<th>Director</th>";
          echo "</tr>";
  
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row["Nombre"]."</td>";
            echo "</tr>";
          }
        } else {
          echo "<p style=\"color:red\">No hay resultados disponibles</p>";
        }
        echo "</table><br><br>";

        $sql = "SELECT Genero FROM Contenido
        WHERE Nombre='$name'";
        $result = mysqli_query($conn, $sql);
        if (!empty($result) && mysqli_num_rows($result) > 0) {
          echo "<table>";
          echo "<tr>";
          echo "<th>Género</th>";
          echo "</tr>";
  
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row["Genero"]."</td>";
            echo "</tr>";
          }
        } else {
          echo "<p style=\"color:red\">No hay resultados disponibles</p>";
        }
        echo "</table><br><br>";

        $sql = "SELECT Año FROM Contenido
        WHERE Nombre='$name'";
        $result = mysqli_query($conn, $sql);
        if (!empty($result) && mysqli_num_rows($result) > 0) {
          echo "<table>";
          echo "<tr>";
          echo "<th>Año</th>";
          echo "</tr>";
  
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row["Año"]."</td>";
            echo "</tr>";
          }
        } else {
          echo "<p style=\"color:red\">No hay resultados disponibles</p>";
        }
        echo "</table><br><br>";

        $sql = "SELECT B.Comentarios FROM Busquedas B, Contenido C
        WHERE C.Nombre='$name' AND B.ID_Contenido=C.ID_Contenido";
        $result = mysqli_query($conn, $sql);
        if (!empty($result) && mysqli_num_rows($result) > 0) {
          echo "<table>";
          echo "<tr>";
          echo "<th>Comentarios</th>";
          echo "</tr>";
  
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row["Comentarios"]."</td>";
            echo "</tr>";
          }
        } else {
          echo "<p style=\"color:red\">No hay comentarios</p>";
        }
        echo "</table>";
      }

      mysqli_close($conn);
    ?>

    <br><br><a href="usuario.php">Regresar</a>
  </body>
</html>