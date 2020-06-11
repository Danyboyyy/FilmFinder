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
    <h1>Favoritos</h1>
  </head>
  <body>
    <?php
      session_start();
      $usuario = $_SESSION['username'];

      $servername = "127.0.0.1";
      $username = "root";
      $password = "Spiderdany10#";
      $database = "FilmFinder";

      $result="";

      // Create connection
      $conn = mysqli_connect($servername, $username, $password, $database);
      // Check connection
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "SELECT ID_Cliente FROM Cliente WHERE Nombre = '$usuario'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_array($result);
      $idU = $row["ID_Cliente"];

      $sql = "SELECT C.Nombre, P.Link, B.Favoritos FROM Busquedas B, Contenido C, Plataforma P, Plataforma_Contenido PC
      WHERE B.Favoritos = 1 AND B.ID_Cliente = ".$idU." AND B.ID_Contenido = C.ID_Contenido AND C.ID_Contenido = PC.ID_Contenido AND P.ID_Plataforma = PC.ID_Plataforma";
      $result = mysqli_query($conn, $sql);

      if (!empty($result) && mysqli_num_rows($result) > 0) {
      
        echo "<table>";
        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Enlace</th>";
        echo "<th>Favorito</th>";
        echo "</tr>";

        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            
          echo "<tr>";
          echo "<td>".$row["Nombre"]."</td>";
          echo "<td>".$row["Link"]."</td>";
          echo "<td>".$row["Favoritos"]."</td>";
          echo "</tr>";
        }
      } else {
        echo "<p style=\"color:red\">No hay resultados disponibles</p>";
      }
      echo "</table>";

      mysqli_close($conn);
    ?>

    <br><br><a href="usuario.php">Regresar</a>
  </body>
</html>