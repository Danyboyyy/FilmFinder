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
    <h1>Members</h1>
  </head>
  <body>
    <h2>Tabla</h2>
    <?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "Spiderdany10#";
    $database = "FilmFinder";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT Contenido FROM Sugerencia";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    
        echo "<table>";
        echo "<tr>";
        echo "<th>Sugerencias</th>";
        echo "</tr>";

        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
          
          echo "<tr>";
          echo "<td>".$row["Contenido"]."</td>";
          echo "</tr>";
        }
    } 
    echo "</table>";

    mysqli_close($conn);
    ?> 
    <a href="admin.php">Regresar</a>
  </body>
</html>